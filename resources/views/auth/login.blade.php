@extends('layouts.login')

@section('content')

<div class="content">
    <div class="ui segment">
        <div class="logo">
            <img src="<?=asset_url('static/img/logo.png')?>" />
        </div>

        <form class="ui form<?=!$errors->isEmpty() ? ' error': ''?>" method="POST" action="{{ url('/login') }}">
            {{ csrf_field() }}

            <div class="field">
                <label>用户名</label>
                <input type="text" name="name" value="{{ old('name') }}" required autocomplete="off" />
            </div>

            <div class="field">
                <label>密码</label>
                <input type="password" name="password" required autocomplete="off" />
            </div>

            <div class="actions">
                <button class="ui basic fluid green button" type="submit">登录</button>
            </div>

            @if ( ! $errors->isEmpty())

            <?php debug($errors)?>
            <div class="ui error message">
                <div class="ui small header">登录失败</div>

                <p>用户名和密码不匹配，请仔细输入。</p>
            </div>
            @endif
        </form>
    </div>
</div>
@endsection
