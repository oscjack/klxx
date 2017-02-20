<?php

namespace App\Http\Controllers;

use InvalidArgumentException;
use Illuminate\Http\Request;
use App\Job;
use App\Service\JobService;
use DB;

class JobController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $service = new JobService();
        $month = $request->input('month') ?: date("m");
        $worker_id = $request->input('workerId');

        return $service->findByMonth($worker_id, $month);
    }

    public function update(Request $request)
    {
        $service = new JobService($request->input('id'));

        try {
            $service->save([
                'product_id' => $request->input('productId'),
                'worker_id' => $request->input('workerId'),
                'quantity' => $request->input('quantity'),
                'month' => $request->input('month'),
                'day' => $request->input('day')
            ]);

            $response = [
                'success' => true,
                'feedback' => '成功：人工费用已保存'
            ];
        }catch (InvalidArgumentException $e) {
            $response = [
                'success' => false,
                'feedback' => $e->getMessage()
            ];
        }

        return response()->json($response);
    }

    public function save(Request $request)
    {
        $service = new JobService($request->input('id'));

        try {
            $service->save([
                'product_id' => $request->input('productId'),
                'worker_id' => $request->input('workerId'),
                'month' => $request->input('month'),
                'day' => $request->input('day'),
                'quantity' => $request->input('quantity')
            ]);

            $response = [
                'success' => true,
                'feedback' => '成功：人工费用已保存'
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
        $service = new JobService($request->input('id'));

        try {
            $service->destroy();

            $response = [
                'success' => true,
                'feedback' => '成功: 人工信息已删除'
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
