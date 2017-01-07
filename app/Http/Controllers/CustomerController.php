<?php

namespace App\Http\Controllers;

use InvalidArgumentException;
use Illuminate\Http\Request;
use App\Customer;

use App\Service\CustomerService;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return Customer::paginate(PAGE_ITEMS);
    }

    public function all()
    {
        return Customer::all();
    }

    public function save(Request $request)
    {
        $service = new CustomerService($request->input('id'));

        try {
            $service->save([
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'telephone' => $request->input('telephone'),
                'address' => $request->input('address'),
                'email_address' => $request->input('email_address')
            ]);

            $response = [
                'success' => true,
                'feedback' => '成功：客户信息已保存'
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
        $service = new CustomerService($request->input('id'));

        try {
            $service->destroy();

            $response = [
                'success' => true,
                'feedback' => '成功: 用户已删除'
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
