<?php

namespace App\Service;

use InvalidArgumentException;
use Illuminate\Support\Facades\Auth;

class ResetPasswordService
{
    protected $old_password;
    protected $password;
    protected $confirm_password;

    public function __construct($old_password, $password, $confirm_password)
    {
        $this->old_password = $old_password;
        $this->password = $password;
        $this->confirm_password = $confirm_password;
    }

    public function reset()
    {
        $user = Auth::user();

        if ( ! $this->old_password) {
            throw new InvalidArgumentException('原密码不能为空');
        }

        if ( ! Auth::attempt([
            'name' => $user->name,
            'password' => $this->old_password
        ])) {
            throw new InvalidArgumentException('原密码输入有误');
        }

        if (empty($this->password)) {
            throw new InvalidArgumentException('新密码不能为空');
        }

        if ($this->password != $this->confirm_password) {
            throw new InvalidArgumentException('两次输入的密码不匹配');
        }

        $user->password = bcrypt($this->password);
        $user->save();
    }
}
