@extends('layouts.mail')

@section('content')
<p>Hello, {{ $details['name'] }} </p>
<p>Please Finish your account activation process!</p>
<p style="text-align:center;margin:30px;">
    <span>Email: {{ $details['email'] }}</span>
    <br>
    <span>Password: {{ $details['password'] }}</span>
    <br>
    <a href="{{ $details['url'] }}"
       style="margin-top: 2rem; border-radius: 5px; color: #FFFFFF;background:#2DC854;color:#FFFFFF;padding:10px 20px;text-decoration:none;font-size:20px;">
        Activate My Account
    </a>
</p>
@endsection
