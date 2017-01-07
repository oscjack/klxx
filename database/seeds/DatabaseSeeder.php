<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->seedSettings();
        $this->seedUsers();
    }

    protected function seedUsers()
    {
        DB::table('users')->insert([
           'name' => 'klxx',
           'email' => 'klxx@qq.com',
           'password' => bcrypt('klxx-boss')
        ]);
    }

    protected function seedSettings()
    {
        DB::table('settings')->insert([
            [
                'key' => 'BRAND_NAME',
                'value' => '益喜宝贝    柯炜王子'
            ],

            [
                'key' => 'BRAND_TITLE',
                'value' => '快乐兴兴精品童裤'
            ],

            [
                'key' => 'MOBILE_PHONES',
                'value' => json_encode([
                    '13901575169',
                    '13915631231',
                    '15851571284'
                ])
            ],

            [
                'key' => 'FIXED_PHONES',
                'value' => json_encode([
                    '0512-52593813',
                    '0512-51539623'
                ])
            ],

            [
                'key' => 'BANK_ACCOUNTS',
                'value' => json_encode([
                    ['name'=>'农行卡', 'number' => '95599 8040 84526 91319'],
                    ['name'=>'工行卡', 'number' => '6222 3144 7718 2715']
                ])
            ],

            [
                'key' => 'CUSTOMER_MESSAGE',
                'value' => '祝新老客户生意兴隆...'
            ],

            [
                'key' => 'SALED_MESSAGE',
                'value' => '货物如有质量问题...'
            ]
        ]);
    }
}
