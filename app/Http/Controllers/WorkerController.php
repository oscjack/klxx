<?php

namespace App\Http\Controllers;

use InvalidArgumentException;
use Illuminate\Http\Request;
use App\Worker;

use App\Service\WorkerService;

class WorkerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return Worker::paginate(PAGE_ITEMS);
    }

    public function save(Request $request)
    {
        $service = new WorkerService($request->input('id'));

        try {
            $service->save([
                'name' => $request->input('name'),
                'type' => $request->input('type'),
                'telephone' => $request->input('telephone')
            ]);

            $response = [
                'success' => true,
                'feedback' => '成功：员工信息已保存'
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
        $service = new WorkerService($request->input('id'));

        try {
            $service->destroy();

            $response = [
                'success' => true,
                'feedback' => '成功: 员工已删除'
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
