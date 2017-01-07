@extends('layouts.dashboard')

@section('content')
<div id="app-mount">
    <app token="{{ csrf_token() }}" admin="{{ $user->name }}"></app>
</div>
@endsection
