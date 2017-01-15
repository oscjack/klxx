<?php

namespace App\Service;

use InvalidArgumentException;
use DB;

class InvoiceService
{
    public function lists($customer_id = null, $status = null)
    {
        $query = DB::table('orders')
        ->join('customers',
            'orders.customer_id',
            '=',
            'customers.id'
        )
        ->select(
            'orders.customer_id',
            'customers.name as customer',
             DB::raw('SUM(total) as total_sales'),
             DB::raw('SUM(paid) as total_paid')
        );

        if ($customer_id) {
            $query->where('customer_id', $customer_id);
        }

        $query->groupBy('customer_id');

        if ($status == 'pending') {
            $query->havingRaw('SUM(total) - SUM(paid) > 0');
        }else if ($status == 'paid') {
            $query->havingRaw('SUM(total) - SUM(paid) < 1');
        }

        $result = $query->paginate(PAGE_ITEMS);

        return $result;
    }

    public function info($customer_id)
    {
        $order_service = new OrderService();

        $data = DB::table('orders')
        ->join('customers',
            'orders.customer_id',
            '=',
            'customers.id'
        )
        ->select(
            'orders.customer_id',
            'customers.name as customer',
             DB::raw('SUM(total) as total_sales'),
             DB::raw('SUM(paid) as total_paid')
        )->where(
            'customer_id',
            $customer_id
        )->groupBy('customer_id')->get();

        $orders = $order_service->all($customer_id);

        return compact('data', 'orders');
    }
}
