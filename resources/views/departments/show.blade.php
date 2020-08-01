@extends('layouts.app')


@section('content')
<a href="/departments" class="btn btn-default">Go Back</a>
<h1>{{$department->title}}</h1>



<h3>Department Employees</h3>
<div class="container">
                    @if(count($department->users) > 0)
                     <!-- Table of employees -->
                        <table class="table table-bordered" id="table">
                            <thead>
                               <tr>
                                 <th>Id</th>
                                  <th>Name</th>
                                  <th>Email</th>
                               </tr>
                            </thead>
             
                            <tbody>
                              @foreach ($department->users as $item)
                              <tr>
                                 <td>{{$item->id}}</td>
                                 <td><a href="/users/{{$item->id}}">{{$item->name}}</a></td>
                                 <td>{{$item->email}}</td>
                                 </tr> 
                                 @endforeach
                              </tbody>
                         </table>
                      </div>

                    @else
                        <h2> </h2>
                        <p>There are no employees in this department</p>
                    @endif
</div>

<div class="container">
<!-- check if department has parent department -->
@if($department->parent_id == 0)
<small>This department has no parent department.</small>
@else
<a href="/departments/{{$department->parent_id}}" class="btn btn-default">Parent Department</a>
@endif
<!-- if user is an admin, edit and delete buttons show -->
@if(!Auth::guest()) 
    @if(Auth::user()->isAdmin) 
    <a href="/departments/{{$department->id}}/edit" class="btn btn-default">Edit</a>
    {!!Form::open(['action' => ['DepartmentsController@destroy', $department->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
                {{Form::hidden('_method', 'DELETE')}}
                {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
                {!!Form::close()!!}
    @endif
@endif
</div>

<script>
    $(document).ready(function(){
       $('#table').DataTable();
 });
 </script>
@endsection