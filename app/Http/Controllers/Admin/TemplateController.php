<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Template;
use Illuminate\Http\Request;

class TemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('admin.template.index',['templates' => Template::paginate(1000)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Template $templete)
    {
        //

        return view('admin.template.create',[
            'templete'=> $templete
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
            'templetesmsname' => ['required', 'string', 'max:255','unique:templates'],
            'description' => ['required','string','max:2048']

        ]);

        Template::create([
            'templetesmsname'=>$request['templetesmsname'],
            'description' => $request['description']
        ]);


        return redirect()->route('admin.template.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Template  $template
     * @return \Illuminate\Http\Response
     */
    public function show(Template $template)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Template  $template
     * @return \Illuminate\Http\Response
     */
    public function edit(Template $template)
    {
        //

        return view('admin.template.edit',[
            'templete'=> $template
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Template  $template
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Template $template)
    {
        //
        $validator =$request->validate( [
            'templetesmsname' => ['required', 'string', 'max:255',\Illuminate\Validation\Rule::unique('templates')->ignore($template->id)],
            'description' => ['required', 'string', 'max:2048'],
        ]);


        $template->templetesmsname=$request['templetesmsname'];
        $template->description=$request['description'];


        $template->save();

        return redirect()->route('admin.template.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Template  $template
     * @return \Illuminate\Http\Response
     */
    public function destroy(Template $template)
    {
        //

        $template->delete();

        return redirect()->route('admin.template.index');
    }
}
