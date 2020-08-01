@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <img src="/uploads/avatars/{{ $user->avatar }}" style="width:120px; height:120px; float:left; border-radius:50%; margin-right:25px;">
                <div class="card-header">{{$user->name}}'s {{ __('Profile') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if ($user->department_id > 0)
                    <h3>Department: <a href="/departments/{{$user->department->id}}">{{ $user->department->title }}</a></h3>
                    @else 
                    <h3>This user does not belong to any department</h3>  
                    @endif
                </div>
            </div>
        </div>
    </div>

    
    <!-- Edit and Delete button show up only to an administrator or the same authenticated user -->
    @if(Auth::user()->isAdmin || Auth::user()->id == $user->id) 
        <h3></h3>
        <a href="/users/{{$user->id}}/edit" class="btn btn-default">Edit</a>
        {!!Form::open(['action' => ['UsersController@destroy', $user->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
        {{Form::hidden('_method', 'DELETE')}}
        {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
        {!!Form::close()!!}
    @endif
    
</div>
@endsection
