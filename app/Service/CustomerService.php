<?php

namespace App\Service;

use InvalidArgumentException;
use App\Customer;
use App\Order;

class CustomerService
{
    protected $customer_id;

    public function __construct($customer_id = null)
    {
        $this->customer_id = $customer_id;
    }

    public function save(array $data)
    {
        $this->validate($data);

        if ($this->customer_id) {
            $customer = Customer::find($this->customer_id);
        }else {
            $customer = new Customer;
        }

        $customer->name = $data['name'];
        $customer->description = $data['description'];
        $customer->telephone = $data['telephone'];
        $customer->address = $data['address'];
        $customer->email_address = $data['email_address'];

        if ( ! $customer->save()) {
            throw new InvalidArgumentException('保存客户失败');
        }
    }

    public function destroy()
    {
        try {
            $customer = Customer::find($this->customer_id);

            if ( ! $customer->delete()) {
                throw new InvalidArgumentException('失败：不能删除改用户');
            }
        }catch (Exception $e) {
            throw new InvalidArgumentException('失败：不能删除改用户');
        }
    }

    protected function validate(array $data)
    {
        if (empty($data['name'])) {
            throw new InvalidArgumentException('客户名字不能为空.');
        }

        if (empty($data['telephone'])) {
            throw new InvalidArgumentException('客户电话不能为空.');
        }

        $order = Order::where('customer_id', $this->customer_id)->first();

        if ($order) {
            throw new InvalidArgumentException('客户有货单记录，不能删除.');
        }
    }
}
