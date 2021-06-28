<?php

namespace App\Http\Controllers\Admin;

use App\Bank;
use App\Color1;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Color1Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('admin.color1.index',['color1s' => Color1::paginate(1000)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Color1 $color1)
    {
        //

        return view('admin.color1.create',[
            'color1'=> $color1
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
            'color1' => ['required', 'string', 'max:255','unique:color1s'],
            'description' => ['required','string','max:2048'],
            'description1' => ['required','string','max:2048'],
            'description2' => ['required','string','max:2048']
        ]);

       Color1::create([
            'color1'=>$request['color1'],
            'description' => $request['description'],
            'description1' => $request['description1'],
            'description2' => $request['description2']
        ]);


        return redirect()->route('admin.color1.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Color1  $color1
     * @return \Illuminate\Http\Response
     */
    public function show(Color1 $color1)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Color1  $color1
     * @return \Illuminate\Http\Response
     */
    public function edit(Color1 $color1)
    {
        //

        return view('admin.color1.edit',[
            'color1'=> $color1
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Color1  $color1
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Color1 $color1)
    {
        //
        $validator =$request->validate( [
            'color1' => ['required', 'string', 'max:255',\Illuminate\Validation\Rule::unique('color1s')->ignore($color1->id)],
            'description' => ['required', 'string', 'max:2048'],
            'description1' => ['required', 'string', 'max:2048'],
            'description2' => ['required', 'string', 'max:2048'],

        ]);


        $color1->color1=$request['color1'];
        $color1->description=$request['description'];
        $color1->description1=$request['description1'];
        $color1->description2=$request['description2'];

        $color1->save();

        return redirect()->route('admin.color1.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Color1  $color1
     * @return \Illuminate\Http\Response
     */
    public function destroy(Color1 $color1)
    {
        //
        $color1->delete();

        return redirect()->route('admin.color1.index');
    }
}
