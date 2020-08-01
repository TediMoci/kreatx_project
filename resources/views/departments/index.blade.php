@extends('layouts.app')

@section('content')

<div class="container">     
    <div class="panel panel-primary">
        <div class="panel-heading">Departments List</div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6">
                        <ul id="tree1">
                            @foreach($departments as $department)
                                <li>
                                    <a href="/departments/{{$department->id}}">{{ $department->title }}</a>
                                    @if(count($department->childs))
                                        @include('departments.manageChild',['childs' => $department->childs])
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>                    
                </div>
            </div>
        </div>   

    <!-- Create department button shows only to administrator -->
    @if(!Auth::guest() && Auth::user()->isAdmin) 
        <a href="/departments/create" class="btn btn-primary">Add New Department</a>
    @endif
    </div>
</div>

@endsection