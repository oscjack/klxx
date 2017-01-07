<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Service\ProductService;
use InvalidArgumentException;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return Product::paginate(PAGE_ITEMS);
    }

    public function save(Request $request)
    {
        $service = new ProductService($request->input('id'));

        try {
            $service->save([
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'model' => $request->input('model'),
                'price' => $request->input('price'),
                'stock_qty' => $request->input('stock_qty')
            ]);

            $response = [
                'success' => true,
                'feedback' => '成功：产品信息已保存'
            ];
        }catch (InvalidArgumentException $e) {
            $response = [
                'success' => false,
                'feedback' => $e->getMessage()
            ];
        }

        return response()->json($response);
    }

    public function remove(Request $request)
    {
        $service = new ProductService($request->input('id'));

        try {
            $service->destroy();

            $response = [
                'success' => true,
                'feedback' => '成功: 产品已删除'
            ];
        }catch (InvalidArgumentException $e) {
            $response = [
                'success' => false,
                'feedback' => $e->getMessage()
            ];
        }

        return response()->json($response);
    }
}
