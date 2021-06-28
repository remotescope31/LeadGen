<?php

namespace App\Http\Controllers\Admin;

use App\Bank;
use App\Http\Controllers\Controller;
use App\Policy;
use Illuminate\Http\Request;

class BankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('admin.bank.index',['banks' => Bank::paginate(1000)
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Bank $bank)
    {
        //
        return view('admin.bank.create',[
            'bank'=> $bank
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
            'name' => ['required', 'string', 'max:255','unique:banks'],
            'phone' => ['required', 'string', 'max:255'],
        ]);

        Bank::create([
            'name'=>$request['name'],
            'phone' => $request['phone']
        ]);
        return redirect()->route('admin.bank.index');


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function show(Bank $bank)
    {
        //
        //  dd($bank);

        //  $polis = DB::table('polis')->where('id_bank',$bank->id)->get();

        return view('admin.bank.show', ['policy' => Policy::query()->where('bank_id',$bank->id)->get()],['bank' => $bank]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function edit(Bank $bank)
    {
        //
        return view('admin.bank.edit',[
            'bank'=> $bank
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bank $bank)
    {
        //

        $validator =$request->validate( [
            'name' => ['required', 'string', 'max:255',\Illuminate\Validation\Rule::unique('users')->ignore($bank->id)],
            'phone' => ['required', 'string', 'max:255'],
        ]);


        $bank->name=$request['name'];
        $bank->phone=$request['phone'];
        $bank->save();

        return redirect()->route('admin.bank.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bank $bank)
    {
        //
        //dd($bank);
        $bank->delete();

        return redirect()->route('admin.bank.index');

    }
}
