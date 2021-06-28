<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Policy;
use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
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
    public function create(Product $product)
    {
        //
        return view('admin.product.create',[
            'product'=> $product
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
            'name_product' => ['required', 'string', 'max:255'],
            'riski' => ['required', 'string', 'max:255'],
            'vid_kred' => ['required', 'string', 'max:255'],
            'poter_rab' => ['required', 'string', 'max:2048'],
            'strah_vipl' => ['required', 'string', 'max:2048'],
        ]);

        Product::create([
            'policy_id'=>$request['policy_id'],
            'name_product'=>$request['name_product'],
            'riski' => $request['riski'],
            'vid_kred'=>$request['vid_kred'],
            'poter_rab'=>$request['poter_rab'],
            'strah_vipl'=>$request['strah_vipl']
        ]);
        // return redirect()->route('admin.bank.index');
        return redirect()->route('admin.policy.show',$request['policy_id']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
        return view('admin.product.edit',['product'=>$product]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $validator =$request->validate( [
            'name_product' => ['required', 'string', 'max:255'],
            'riski' => ['required', 'string', 'max:255'],
            'vid_kred' => ['required', 'string', 'max:255'],
            'poter_rab' => ['required', 'string', 'max:2048'],
            'strah_vipl' => ['required', 'string', 'max:2048'],
        ]);



            $product->name_product = $request['name_product'];
            $product->riski = $request['riski'];
            $product->vid_kred =$request['vid_kred'];
            $product->poter_rab = $request['poter_rab'];
            $product->strah_vipl = $request['strah_vipl'];


       $product->save();

        //  return redirect()->route('admin.bank.index');
      // return view('admin.policy.show', ['product' => Product::query()->where('policy_id',$product->policy_id)->get()],['policy' => Policy::query()->where('id',$product->policy_id)->first()]);
        return redirect()->route('admin.policy.show',$product->policy_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
        $product->delete();

//        return view('admin.policy.show', ['product' => Product::query()->where('policy_id',$product->policy_id)->get()],['policy' => Policy::query()->where('id',$product->policy_id)->first()]);
        return redirect()->route('admin.policy.show',$product->policy_id);
    }
}
