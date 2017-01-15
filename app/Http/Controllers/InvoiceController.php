<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service\InvoiceService;
use App\Service\OrderService;

class InvoiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $invoice_service = new InvoiceService();
        $customer_id = $request->input('customer_id');
        $status = $request->input('status');

        return $invoice_service->lists($customer_id, $status);
    }

    public function orders(Request $request)
    {
        $order_service = new OrderService();

        $orders = $order_service->lists(
            $request->input('customer_id')
        );

        return $orders;
    }

    public function info($id)
    {
        $invoice_service = new InvoiceService();

        $invoice = $invoice_service->info($id);

        return view(
            'order.invoice',
            [
                'invoice' => $invoice['data'][0],
                'orders' => $invoice['orders']
            ]
        );
    }
}
