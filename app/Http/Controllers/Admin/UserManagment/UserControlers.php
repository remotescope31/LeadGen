<?php

namespace App\Http\Controllers\Admin\UserManagment;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserControlers extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.user_managment.users.index',[
           'users'=> User::paginate(1000)
        ]);


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(User $user)
    {
        return view('admin.user_managment.users.create',[
            'user'=> $user
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {





        $validator =$request->validate( [
            'name' => ['required', 'string', 'max:255'],
            'nickname' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);


        if(($request['role'] > Auth::user()->role))
        {
            return redirect()->route('admin.user_managment.users.index');
        }





        User::create([
            'name'=>$request['name'],
            'nickname' => $request['nickname'],
            'internalphone' => $request['internalphone'],
            'role' => $request['role'],
            'password' => bcrypt($request['password'])
        ]);
        return redirect()->route('admin.user_managment.users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('admin.user_managment.users.edit',[
            'user'=> $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $validator =$request->validate( [
            'name' => ['required', 'string', 'max:255'],
            'nickname' => ['required', 'string', 'max:255', \Illuminate\Validation\Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
        ]);

        if(($request['role'] > Auth::user()->role))
        {
            return redirect()->route('admin.user_managment.users.index');
        }

        $user->name=$request['name'];
        $user->nickname=$request['nickname'];
        $user->internalphone=$request['internalphone'];
        $user->role=$request['role'];
        $request['password'] == null ?: $user->password = bcrypt($request['password']);
        $user->save();

        /*User::create([
            'name'=>$request['name'],
            'nickname' => $request['nickname'],
            'internalphone' => $request['internalphone'],
            'role' => $request['role'],
            'password' => bcrypt($request['password'])
        ]);*/
        return redirect()->route('admin.user_managment.users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {

        if(($user->role > Auth::user()->role))
        {
            return redirect()->route('admin.user_managment.users.index');
        }


        $user->delete();

        return redirect()->route('admin.user_managment.users.index');
    }
}
