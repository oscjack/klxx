<?php

namespace App\Http\Controllers;

use App\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $settings = Setting::all();

        $settings->map(function ($item) {
            if (in_array(
                $item->key, [
                'MOBILE_PHONES',
                'FIXED_PHONES',
                'BANK_ACCOUNTS'
            ])) {
                $item->value = json_decode($item->value);
            }

            return $item;
        });

        return $settings;
    }

    public function save(Request $request)
    {
        foreach ([
            'BRAND_NAME',
            'BRAND_TITLE',
            'CUSTOMER_MESSAGE',
            'SALED_MESSAGE'] as $key) {
            Setting::where('key', "$key")->update([
                'value' => $request->input($key)
            ]);
        }

        foreach ([
            'MOBILE_PHONES',
            'FIXED_PHONES',
            'BANK_ACCOUNTS'] as $key) {
            Setting::where('key', "$key")->update([
                'value' => json_encode($request->input($key))
            ]);
        }

        return response()->json(['success' => true, 'feedback' => '成功：设置已更新']);
    }
}
