@extends('layouts.app')

@section('content')
<a href="/departments" class="btn btn-default">Go Back</a>

<h1>Edit Department</h1>
{!! Form::open(['action' => ['DepartmentsController@update', $department->id], 'method' => 'POST']) !!}

<!-- Title form -->
<div class="form-group">
    {{Form::label('title', 'Title')}}
    {{Form::text('title', $department->title, ['class' => 'form-control', 'placeholder' => 'Title'])}}
</div>

<!-- Parent department form -->
<div class="form-group {{ $errors->has('parent_id') ? 'has-error' : '' }}">
    {!! Form::label('Department:') !!}
    {!! Form::select('parent_id',$allDepartments, old('parent_id'), ['class'=>'form-control', 'placeholder'=>'Choose department']) !!}
    <span class="text-danger">{{ $errors->first('parent_id') }}</span>
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