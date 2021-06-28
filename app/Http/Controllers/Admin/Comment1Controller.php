<?php

namespace App\Http\Controllers\Admin;

use App\Color1;
use App\Comment1;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Comment1Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('admin.comment1.index',['comment1s' => Comment1::paginate(1000)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Comment1 $comment1)
    {
        //
        return view('admin.comment1.create',[
            'comment1'=> $comment1
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
        //
        //
        $validator =$request->validate( [
            'comment1' => ['required', 'string', 'max:255','unique:comment1s']
        ]);

        Comment1::create([
            'comment1'=>$request['comment1']

        ]);


        return redirect()->route('admin.comment1.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Comment1  $comment1
     * @return \Illuminate\Http\Response
     */
    public function show(Comment1 $comment1)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Comment1  $comment1
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment1 $comment1)
    {
        //

        return view('admin.comment1.edit',[
            'comment1'=> $comment1
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Comment1  $comment1
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment1 $comment1)
    {
        //
        $validator =$request->validate( [
            'comment1' => ['required', 'string', 'max:255',\Illuminate\Validation\Rule::unique('comment1s')->ignore($comment1->id)]
        ]);


        $comment1->comment1=$request['comment1'];

        $comment1->save();

        return redirect()->route('admin.comment1.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Comment1  $comment1
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment1 $comment1)
    {
        //
        $comment1->delete();

        return redirect()->route('admin.comment1.index');
    }
}
