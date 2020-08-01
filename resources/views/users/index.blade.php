@extends('layouts.app')

@section('content')
         <div class="container">
            <h2>Users List</h2>
            <!-- Datatable of users -->
            <table class="table table-bordered" id="table">
               <thead>
                  <tr>
                     <th>Id</th>
                     <th>Name</th>
                     <th>Email</th>
                     <th>Department</th>
                  </tr>
               </thead>

               <tbody>
                  @foreach ($data as $item)
                 <tr>
                    <td>{{$item->id}}</td>
                    <td><a href="/users/{{$item->id}}">{{$item->name}}</a></td>
                    <td>{{$item->email}}</td>
                    <td>@if($item->department_id > 0)
                        <a href="/departments/{{$item->department->id}}">{{$item->department->title}}</a>
                        @else
                        No Department
                        @endif
                     </td>
                    </tr> 
                    @endforeach
                  </tbody>
            </table>
         </div>

      <!-- Create User button, shows up only for administrator -->
      @if(!Auth::guest()) 
        @if(Auth::user()->isAdmin) 
        <a href="/users/create" class="btn btn-primary">Create User</a>
        @endif
      @endif

<script>
   $(document).ready(function(){
      $('#table').DataTable();
});
</script>

@endsection