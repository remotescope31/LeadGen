<?php

namespace App\Http\Controllers\Admin;

use App\Color2;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Color2Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('admin.color2.index',['color2s' => Color2::paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(color2 $color2)
    {
        //

        return view('admin.color2.create',[
            'color2'=> $color2
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
        $validator =$request->validate( [
            'color2' => ['required', 'string', 'max:255','unique:color2s'],
            'description' => ['required','string','max:2048']
        ]);

        Color2::create([
            'color2'=>$request['color2'],
            'description' => $request['description']
        ]);


        return redirect()->route('admin.color2.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\color2  $color2
     * @return \Illuminate\Http\Response
     */
    public function show(color2 $color2)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\color2  $color2
     * @return \Illuminate\Http\Response
     */
    public function edit(color2 $color2)
    {
        //

        return view('admin.color2.edit',[
            'color2'=> $color2
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\color2  $color2
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, color2 $color2)
    {
        //
        $validator =$request->validate( [
            'color2' => ['required', 'string', 'max:255',\Illuminate\Validation\Rule::unique('color2s')->ignore($color2->id)],
            'description' => ['required', 'string', 'max:2048'],
        ]);


        $color2->color2=$request['color2'];
        $color2->description=$request['description'];
        $color2->save();

        return redirect()->route('admin.color2.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\color2  $color2
     * @return \Illuminate\Http\Response
     */
    public function destroy(color2 $color2)
    {
        //
        $color2->delete();

        return redirect()->route('admin.color2.index');
    }
}
