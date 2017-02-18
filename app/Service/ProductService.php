<?php

namespace App\Service;

use InvalidArgumentException;
use App\Product;
use App\OrderProduct;

class ProductService
{
    protected $product_id;

    public function __construct($product_id = null)
    {
        $this->product_id = $product_id;
    }

    public function save(array $data)
    {
        $this->validate($data);

        if ($this->product_id) {
            $product = Product::find($this->product_id);
        }else {
            $product = new Product;
        }

        $product->name = $data['name'];
        $product->price = $data['price'];
        $product->fee = $data['fee'];
        $product->model = $data['model'] ?: null;
        $product->stock_qty = $data['stock_qty'] ?: null;
        $product->description = $data['description'] ?: null;

        if ( ! $product->save()) {
            throw new InvalidArgumentException('保存产品失败');
        }
    }

    public function destroy()
    {
        try {
            $product = Product::find($this->product_id);

            $order_product = OrderProduct::where('product_id', $this->product_id)->first();

            if ($order_product) {
                throw new InvalidArgumentException('产品有相关的货单记录，故不能删除.');
            }

            if ( ! $product->delete()) {
                throw new InvalidArgumentException('失败：不能删除该用户');
            }
        }catch (Exception $e) {
            throw new InvalidArgumentException('失败：不能删除该用户');
        }
    }

    protected function validate(array $data)
    {
        if (empty($data['name'])) {
            throw new InvalidArgumentException('产品名字不能为空.');
        }

        if (empty($data['price'])) {
            throw new InvalidArgumentException('产品价格不能为空.');
        }

    }
}
