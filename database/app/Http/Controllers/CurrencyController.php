<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $values = Currency::orderBy('id', 'desc')->where('is_active','1')->get();
        return view('forex.currency')->with('values', $values);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'currency_name'=> 'required',
            'currency_country'=> 'required',
            'buying_rate'=> 'required',
            'selling_rate'=> 'required',
            'usd_exrate'=> 'required',

        ]);

        Currency::create($request->all());

        return redirect()->back()->with('success','Record created successfully!!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function show(Currency $currency)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function edit(Currency $currency)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Currency $id)
    {
        $request->validate([
            'currency_name'=> 'required',
            'currency_country'=> 'required',
            'buying_rate'=> 'required|numeric',
            'selling_rate'=> 'required|numeric',
            'usd_exrate'=> 'required|numeric',

        ]);
        $id->update($request->all());
        return redirect()->back()->with('success', 'Item was updated successfully !!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function destroy(Currency $id)
    {
        $id->delete();
        return redirect()->back()->with('success', 'Item was deleted successfully !!');
    }
}
