<?php

namespace App\Http\Controllers;
use App\User;
use App\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //different ways of getting data:
        //$data = User::all();
        //return User::where('title', 'admin')->get();
        //$data = DB::select('SELECT * FROM users');
        //$data = User::orderBy('title','desc')->take(1)->get();
        //$data = User::orderBy('title','desc')->get();
        //$data = User::orderBy('title','asc')->paginate(10);

        $data = User::all();
        return view('users.index')->with('data', $data);
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
            return redirect('/users')->with('error', 'Unauthorized Page');
        }
        //returns all departments to assign the user to
        $allDepartments = Department::orderBy('title','asc')->pluck('title','id')->all();
        return view('users.create', compact('allDepartments'));
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'required_with:password_confirm', 'same:password-confirm'],
        ]);

        // Check if user is admin, if not send back
        if(!(auth()->user()->isAdmin)){
            return redirect('/users')->with('error', 'Unauthorized Page');
        }

        $user = new User;
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->isAdmin = $request->input('isAdmin');
        //checks i department_id field is null
        if($request->input('department_id') != null) $user->department_id = $request->input('department_id');

        $user->save();
        return redirect('/users')->with('success', 'User Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return view('users.show')->with('user', $user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Check if user is admin or the authenticated user, if not send back
        if(!(auth()->user()->isAdmin) && auth()->user()->id != $id){
            return redirect('/users')->with('error', 'Unauthorized Page');
        }

        $user = User::find($id);
        $allDepartments = Department::orderBy('title','asc')->pluck('title','id')->all();
        return view('users.edit')->with('user', $user)->with('allDepartments', $allDepartments);
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
        // Check if user is admin or the authenticated user, if not send back
        if(!(auth()->user()->isAdmin) && auth()->user()->id != $id){
            return redirect('/users')->with('error', 'Unauthorized Page');
        }

        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
        ]);

        $user = User::find($id);

        $user->name = $request->input('name');
        //checks if department_id field is null
        if($request->input('department_id') != null){ 
            $user->department_id = $request->input('department_id');
        }else{$user->department_id = 0;
        }
        //checks if user is administrator
        if(!$user->isAdmin) $user->isAdmin = $request->input('isAdmin');

        $user->save();
        return redirect('/users')->with('success', 'User Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Check if user is admin or the authenticated user, if not send back
        if(!(auth()->user()->isAdmin) && auth()->user()->id != $id){
            return redirect('/users')->with('error', 'Unauthorized Page');
        }

        $user = User::find($id);
        $user->delete();
        return redirect('/users')->with('success', 'User Deleted');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function changePassword($id)
    {
        $user = User::find($id);
        return view('users.changePassword')->with('user', $user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updatePassword(Request $request, $id)
    {
        // Check if user is admin or the authenticated user, if not send back
        if(!(auth()->user()->isAdmin) && auth()->user()->id != $id){
            return redirect('/users')->with('error', 'Unauthorized Page');
        }

        $this->validate($request, [
            'password' => ['string', 'min:8', 'required_with:password_confirm', 'same:password-confirm', 'different:oldpassword'],
        ]);

        $user = User::find($id);
        //check if the old password is actually correct
        if (!(Hash::check($request->get('oldpassword'), $user->password))) {
            return redirect('/users')->with('error', 'Current password does not match!');
        }

        $user->password = Hash::make($request->input('password'));
        $user->save();
        return redirect('/users')->with('success', 'Password Updated');
    }
}
