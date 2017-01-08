<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use InvalidArgumentException;

use App\Service\OrderService;
use App;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $service = new OrderService();

        $orders = $service->lists(
            $request->input('customer_id'),
            $request->input('status')
        );

        return response()->json($orders);
    }

    public function remove(Request $request)
    {
        $order_id = $request->input('id');

        Order::destroy($order_id);

        return response()->json([
            'success' => true,
            'feedback' => '成功：货单已删除'
        ]);
    }

    public function save(Request $request)
    {
        $service = new OrderService($request->input('id'));

        try {
            $service->save([
                'customer_id' => $request->input('customer_id'),
                'paid' => $request->input('paid'),
                'status' => $request->input('status'),
                'description' => $request->input('description'),
                'products' => $request->input('products')
            ]);

            $response = [
                'success' => true,
                'feedback' => '成功：货单信息已保存'
            ];
        }catch (InvalidArgumentException $e) {
            $response = [
                'success' => false,
                'feedback' => $e->getMessage()
            ];
        }

        return response()->json($response);
    }

    public function info($id)
    {
        $service = new OrderService($id);

        try {
            $order_detail = $service->detail();
        }catch (InvalidArgumentException $e) {
            App::abort(404);
        }

        return view('order.info', ['detail' => $order_detail]);
    }

    public function products(Request $request)
    {
        $service = new OrderService($request->input('id'));

        $products = $service->getProducts();

        return response()->json($products);
    }
}
