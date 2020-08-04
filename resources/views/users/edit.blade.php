@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
<img src="/uploads/avatars/{{ $user->avatar }}" style="width:120px; height:120px; float:left; border-radius:50%; margin-right:25px;">
<h1>Edit User</h1>
<a href="/users/{{$user->id}}" class="btn btn-default">Back to User Profile</a>

</div>

{!! Form::open(['action' => ['UsersController@update', $user->id], 'method' => 'POST']) !!}
<!-- Name form -->
<div class="form-group">
    {{Form::label('name', 'Name:')}}
    {{Form::text('name', $user->name, ['class' => 'form-control', 'placeholder' => 'Name'])}}
</div>

<!-- Department form -->
<div class="form-group {{ $errors->has('parent_id') ? 'has-error' : '' }}">
    {!! Form::label('Department:') !!}
    {!! Form::select('department_id',$allDepartments, old('department_id'), ['class'=>'form-control', 'placeholder'=>'Choose department']) !!}
    <span class="text-danger">{{ $errors->first('department_id') }}</span>
</div>

<!-- Administrator form - shows up only if the user is not already an administrator-->
@if(!($user->isAdmin) && Auth::user()->isAdmin)
<div class="form-group{{ $errors->has('isAdmin') ? ' has-error' : '' }}">
    {!! Form::label('Is this user an administrator:') !!}
    <select class="form-control" name="isAdmin" id="isAdmin" value="True">
        <option value="1" @if (old('isAdmin') == 1) selected @endif>True</option>
        <option value="0" @if (old('isAdmin') == 0) selected @endif>False</option>
    </select>
</div>
@endif

<!-- Spoof method PUT -->
{{Form::hidden('_method','PUT')}}
<!-- Submit button -->
{{Form::submit('Submit', ['class'=>'btn btn-primary'])}}

{!! Form::close() !!}

<!-- Sends you to the change password page -->
<h1></h1>
<p><a href="/users/{{$user->id}}/edit/password">Change Password</a></p>

@if (session('error'))
<div class="alert alert-danger">{{ session('error') }}</div>
@endif

@endsection