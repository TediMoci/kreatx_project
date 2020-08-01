@extends('layouts.app')

@section('content')
<div class="col-md-6">
    <h3>Add New Department</h3>
    {!! Form::open(['action' => 'DepartmentsController@store', 'method' => 'POST']) !!}

    <!-- Title form -->
    <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
        {!! Form::label('Title:') !!}
        {!! Form::text('title', old('title'), ['class'=>'form-control', 'placeholder'=>'Enter Title']) !!}
        <span class="text-danger">{{ $errors->first('title') }}</span>
    </div>

    <!-- Parent department form -->
    <div class="form-group {{ $errors->has('parent_id') ? 'has-error' : '' }}">
        {!! Form::label('Department:') !!}
        {!! Form::select('parent_id',$allDepartments, old('parent_id'), ['class'=>'form-control', 'placeholder'=>'Select Department']) !!}
        <span class="text-danger">{{ $errors->first('parent_id') }}</span>
    </div>

    <div class="form-group">
        <button class="btn btn-primary">Add New</button>
    </div>
    {!! Form::close() !!}
</div>
@endsection