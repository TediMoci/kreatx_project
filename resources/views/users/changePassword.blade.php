@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
<img src="/uploads/avatars/{{ $user->avatar }}" style="width:120px; height:120px; float:left; border-radius:50%; margin-right:25px;">
<h1>Edit Password</h1>
<a href="/users/{{$user->id}}" class="btn btn-default">Back to User Profile</a>

</div>

{!! Form::open(['action' => ['UsersController@updatePassword', $user->id], 'method' => 'POST']) !!}

<div class="form-group">
    {!! Form::label('oldpassword', 'Current Password:') !!}
    {!! Form::password('oldpassword',['class' => 'form-control', 'placeholder' => 'Current Password', 'type' => 'Password']) !!}
</div>

<div class="form-group">
    {!! Form::label('password', 'New Password:') !!}
    {!! Form::password('password',['class' => 'form-control', 'placeholder' => 'New Password', 'type' => 'Password']) !!}
</div>

<div class="form-group">
    {!! Form::label('password-confirm', 'Confirm Password:') !!}
    {!! Form::password('password-confirm',['class' => 'form-control', 'placeholder' => 'Confirm Password', 'type' => 'password-confirm']) !!}
</div>

<!-- Spoof method PUT -->
{{Form::hidden('_method','PUT')}}
<!-- Submit button -->
{{Form::submit('Submit', ['class'=>'btn btn-primary'])}}

{!! Form::close() !!}

@if (session('error'))
<div class="alert alert-danger">{{ session('error') }}</div>
@endif
@endsection