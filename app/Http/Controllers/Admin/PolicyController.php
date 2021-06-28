<?php

namespace App\Http\Controllers\Admin;

use App\Bank;
use App\Http\Controllers\Controller;
use App\Policy;
use App\Product;
use Illuminate\Http\Request;

class PolicyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Policy $policy)
    {
        //
        return view('admin.policy.create',[
            'policy'=> $policy
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
            'name_policy' => ['required', 'string', 'max:255'],
            'regex_policy' => ['required', 'string', 'max:255'],
            'type_product' => ['required', 'string', 'max:255'],
        ]);

        Policy::create([
            'bank_id'=>$request['bank_id'],
            'name_policy'=>$request['name_policy'],
            'regex_policy' => $request['regex_policy'],
            'type_product' => $request['type_product']

        ]);
        // return redirect()->route('admin.bank.index');
        return redirect()->route('admin.bank.show',$request['bank_id']);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Policy  $policy
     * @return \Illuminate\Http\Response
     */
    public function show(Policy $policy)
    {
        //
        //return view('admin.policy.show',['policy'=>$policy]);
        return view('admin.policy.show', ['product' => Product::query()->where('policy_id',$policy->id)->get()],['policy' => $policy]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Policy  $policy
     * @return \Illuminate\Http\Response
     */
    public function edit(Policy $policy)
    {
        //
        return view('admin.policy.edit',['policy'=>$policy]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Policy  $policy
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Policy $policy)
    {
        //
        $validator =$request->validate( [
            'name_policy' => ['required', 'string', 'max:255'],
            'regex_policy' => ['required', 'string', 'max:255'],
            'type_product' => ['required', 'string', 'max:255'],

        ]);


        $policy->name_policy=$request['name_policy'];
        $policy->regex_policy=$request['regex_policy'];
        $policy->type_product= $request['type_product'];
        $policy->save();

      //  return redirect()->route('admin.bank.index');
//        return view('admin.bank.show', ['policy' => Policy::query()->where('bank_id',$policy->bank_id)->get()],['bank' => Bank::query()->where('id',$policy->bank_id)->first()]);
        return redirect()->route('admin.bank.show',$policy->bank_id);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Policy  $policy
     * @return \Illuminate\Http\Response
     */
    public function destroy(Policy $policy,Request $request)
    {
        //




        //dd(Bank::query()->where('id',$policy->bank_id)->first());
        $policy->delete();
      //  return view('admin.bank.show', ['policy' => Policy::query()->where('bank_id',$policy->bank_id)->get()],['bank' => Bank::query()->where('id',$policy->bank_id)->first()]);
        return redirect()->route('admin.bank.show',$policy->bank_id);

    }
}
