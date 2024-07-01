<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Currency;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $currencies = Currency::orderBy('currency_name', 'asc')->where('is_active','1')->get();
        $values = Account::leftJoin('currencies','accounts.default_currency','=','currencies.id')
        ->select('*','accounts.id as actId')->where('accounts.is_active','1')->orderBy('currencies.id','asc')->get();
        return view('forex.accounts', compact('values','currencies'));
    }

    public function index2()
    {
        $currencies = Currency::orderBy('currency_name', 'asc')->where('is_active','1')->get();
        $values = Account::leftJoin('currencies','accounts.default_currency','=','currencies.id')->orderBy('accounts.id', 'desc')
        ->select('*','accounts.id as actId')->selectRaw('SUM(available_balance) AS total_income')->where('accounts.is_active','1')->groupBy('default_currency')->get();
        return view('forex.accountsbalances', compact('values','currencies'));
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
         'account_name'=> 'required',
        'account_number'=> 'required',
        'default_currency'=> 'required',
        'account_type'=> 'required',
        //'cleared_balance'=> 'required',
        'available_balance'=> 'required',
        'user_id'=> 'required',
        ]);

        $record =Account::where('account_name',$request->account_name)->first();
        if($record){
            return redirect()->back()->with('warning','Not saved! Integrity constraint violation: 1062 Duplicate entry for account name!');
        }else{

            Account::create($request->all());
        }

        return redirect()->back()->with('success','Record created successfully!!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function show(Account $account)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function edit(Account $account)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Account $id)
    {
        $request->validate([
            'account_name'=> 'required',
           'account_number'=> 'required',
           'default_currency'=> 'required',
           'account_type'=> 'required',
           //'cleared_balance'=> 'required',
           //'available_balance'=> 'required',
           'user_id'=> 'required',
           ]);

           $id->update($request->all());

           return redirect()->back()->with('success','Record created successfully!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function destroy(Account $id)
    {
        $id->delete();
        return redirect()->back()->with('success', 'Account was deleted successfully !!');
    }
}
