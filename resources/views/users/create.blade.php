@extends('layouts.app')

@section('content')
<div class="col-md-6">
    <h3>Create New User as Administrator</h3>
    {!! Form::open(['action' => 'UsersController@store', 'method' => 'POST']) !!}

    <!-- Name form -->
    <div class="form-group">
        {!! Form::label('name', 'Name:') !!}
        {!! Form::text('name', $value = null, ['class' => 'form-control', 'placeholder' => 'Name']) !!}
    </div>

    <!-- Email form -->
    <div class="form-group">
        {!! Form::label('email', 'Email:') !!}
        {!! Form::email('email', $value = null, ['class' => 'form-control', 'placeholder' => 'Email']) !!}
    </div>

    <!-- Password form -->
    <div class="form-group">
        {!! Form::label('password', 'Password:') !!}
        {!! Form::password('password',['class' => 'form-control', 'placeholder' => 'Password', 'type' => 'Password']) !!}
    </div>

    <!-- Password confirmation form -->
    <div class="form-group">
        {!! Form::label('password-confirm', 'Confirm Password:') !!}
        {!! Form::password('password-confirm',['class' => 'form-control', 'placeholder' => 'Confirm Password', 'type' => 'password-confirm']) !!}
    </div>

    <!-- Department form -->
    <div class="form-group {{ $errors->has('department_id') ? 'has-error' : '' }}">
        {!! Form::label('Department:') !!}
        {!! Form::select('department_id',$allDepartments, old('department_id'), ['class'=>'form-control', 'placeholder'=>'Select Department']) !!}
        <span class="text-danger">{{ $errors->first('department_id') }}</span>
    </div>

    <!-- Administrator form -->
    <div class="form-group{{ $errors->has('isAdmin') ? ' has-error' : '' }}">
        {!! Form::label('Is this user an administrator:') !!}
        <select class="form-control" name="isAdmin" id="isAdmin">
            <option value="1" @if (old('isAdmin') == 1) selected @endif>True</option>
            <option value="0" @if (old('isAdmin') == 0) selected @endif>False</option>
        </select>
    </div>

    <div class="form-group">
        <button class="btn btn-primary">Create New</button>
    </div>

    {!! Form::close() !!}
</div>
@endsection