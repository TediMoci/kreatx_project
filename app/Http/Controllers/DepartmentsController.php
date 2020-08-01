<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Department;

class DepartmentsController extends Controller
{
        /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departments = Department::where('parent_id', '=', NULL)->get();
        return view('departments.index',compact('departments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Check if user is admin, if not send back
        if(!(auth()->user()->isAdmin)){
            return redirect('/departments')->with('error', 'Unauthorized Page');
        }

        $allDepartments = Department::orderBy('title','asc')->pluck('title','id')->all();
        return view('departments.create', compact('allDepartments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => ['required', 'unique:departments'],
        ]);

        // Check if user is admin, if not send back
        if(!(auth()->user()->isAdmin)){
            return redirect('/departments')->with('error', 'Unauthorized Page');
        }

        $input = $request->all();
        Department::create($input);
        return redirect('/departments')->with('success', 'Department Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $department = Department::find($id);
        
        return view('departments.show')->with('department', $department);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Check if user is admin, if not send back
        if(!(auth()->user()->isAdmin)){
            return redirect('/departments')->with('error', 'Unauthorized Page');
        }
        
        $department = Department::find($id);
        $allDepartments = Department::orderBy('title','asc')->pluck('title','id')->all();

        return view('departments.edit')->with('department', $department)->with('allDepartments', $allDepartments);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $department = Department::find($id);

        $this->validate($request, [
        'title' => ['required', 'unique:departments,title,'.$id],
        ]);

        // Check if user is admin, if not send back
        if(!(auth()->user()->isAdmin)){
            return redirect('/departments')->with('error', 'Unauthorized Page');
        }

        
        $parentDepartment = Department::find($request->input('parent_id'));

        // Check if department is subdivision of itself or its own subdivision
        if (!empty($parentDepartment)) {
            if ($department == $parentDepartment || $parentDepartment->isDescendantOf($department)) {
                return redirect('/departments')->with('error', 'Department cannot be a subdepartment of itself or its own subdepartments');
            }
        }

        $department->title = $request->input('title');
        $department->parent_id = $request->input('parent_id');
        
        $department->save();
        return redirect('/departments')->with('success', 'Department Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Check if user is admin, if not send back
        if(!(auth()->user()->isAdmin)){
            return redirect('/departments')->with('error', 'Unauthorized Page');
        }

        $department = Department::find($id);
        
        // Check if there are still employees in the department or its subdepartments
        $users = $department->users;
        if(($users->isNotEmpty())){
            return redirect('/departments')->with('error', 'Cannot delete department if there are still employees in it');
        }

        $children = $department->childs;
        foreach ($children as $child){
            $childUsers = $child->users;
            if(($childUsers->isNotEmpty())){
                return redirect('/departments')->with('error', 'Cannot delete department if subdepartments still have employees');
            }
        }

        $department->delete();
        return redirect('/departments')->with('success', 'Department Deleted');
    }

}
