<?php

namespace App\Service;

use InvalidArgumentException;
use App\Order;
use App\Product;
use DB;
use App\Setting;

class OrderService
{
    protected $order_id;

    public function __construct($order_id = null)
    {
        $this->order_id= $order_id;
    }

    public function lists($customer_id = 0, $status = 'none')
    {
        $query = DB::table('orders')
            ->join('customers', 'orders.customer_id', '=', 'customers.id')
            ->select('orders.*', 'customers.name as customer');

        if ($customer_id) {
            $query->where('customers.id', $customer_id);
        }

        if (in_array($status, [
            'pending',
            'paid',
            'sending',
            'received'])) {
            $query->where('orders.status', $status);
        }

        $orders = $query
            ->orderBy('orders.created_at', 'desc')
            ->paginate(PAGE_ITEMS);

        return $orders;
    }

    public function detail()
    {
        $result = [];

        $result['order'] = DB::table('orders')
            ->join('customers', 'orders.customer_id', '=', 'customers.id')
            ->select('orders.*', 'customers.name as customer')
            ->where('orders.id', $this->order_id)
            ->first();


        if (!count($result['order'])) {
            throw new InvalidArgumentException('货单信息不存在。');
        }

        $result['order_products'] = $this->getProducts();

        $settings = Setting::all();

        $result['settings'] = [];
        foreach ($settings as $setting) {
            if (in_array($setting->key,
                ['MOBILE_PHONES', 'FIXED_PHONES', 'BANK_ACCOUNTS']
            )) {
                $setting->value = json_decode($setting->value);
            }

            $result['settings'][$setting->key] = $setting;
        }

        return $result;
    }

    public function save(array $data)
    {
        $this->validate($data);

        if ($this->order_id) {
            $order = Order::find($this->order_id);
        }else {
            $order = new Order;
        }

        $order->customer_id = $data['customer_id'];
        $order->paid = $data['paid'];
        $order->status = $data['status'];
        $order->description = $data['description'];
        $order->total = $this->getOrderTotal($data['products']);

        if ( ! $order->save()) {
            throw new InvalidArgumentException('保存货单失败');
        }

        $this->saveOrderProducts($order->id, $data['products']);
    }

    public function getProducts()
    {
        $products = DB::table('orders_products')
            ->join('products', 'orders_products.product_id', '=', 'products.id')
            ->where('order_id', $this->order_id)
            ->select('products.*', 'orders_products.qty')
            ->get();

        return $products;
    }

    public function destroy()
    {
        try {
            $customer = Customer::find($this->customer_id);

            if ( ! $customer->delete()) {
                throw new InvalidArgumentException('失败：不能删除改用户');
            }
        }catch (Exception $e) {
            throw new InvalidArgumentException('失败：不能删除改用户');
        }
    }

    protected function saveOrderProducts($order_id, $products = [])
    {
        DB::table('orders_products')->where('order_id', $order_id)->delete();

        $records = [];
        foreach ($products as $product) {
            $p = Product::find($product['id']);

            if ($p->stock_qty >= $product['qty']) {
                $p->stock_qty -= $product['qty'];
            }else {
                $p->stock_qty = 0;
            }

            $p->save();

            $records[] = [
                'order_id' => $order_id,
                'product_id' => $product['id'],
                'qty' => $product['qty'],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
        }

        DB::table('orders_products')->insert($records);
    }

    protected function getOrderTotal(array $products = [])
    {
        $total = 0;

        foreach ($products as $product) {
            $total += $product['qty'] * $product['price'];
        }

        return $total;
    }

    protected function validate(array $data)
    {
        if (empty($data['customer_id'])) {
            throw new InvalidArgumentException('请选择该货单的客户.');
        }

        if (empty($data['products'])) {
            throw new InvalidArgumentException('请选择该货单的相关产品.');
        }
    }
}
