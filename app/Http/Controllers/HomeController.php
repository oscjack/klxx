<?php

namespace App\Http\Controllers;

use InvalidArgumentException;
use Illuminate\Http\Request;
use Auth;
use App\Service\ResetPasswordService;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        return view('dashboard', compact('user'));
    }

    public function resetPassword(Request $request)
    {
        $response = [];

        $old_password = $request->input('old_password');
        $password = $request->input('password');
        $confirm_password = $request->input('confirm_password');

        $service = new ResetPasswordService(
            $old_password,
            $password,
            $confirm_password
        );

        try {
            $service->reset();

            $response = ['success' => true, 'feedback' => '密码修改成功。'];
        }catch (InvalidArgumentException $e) {
            $response = ['success' => false, 'feedback' => $e->getMessage()];
        }

        return response()->json($response);
    }
}
