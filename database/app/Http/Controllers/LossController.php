<?php

namespace App\Http\Controllers;

use App\Models\loss;
use App\Models\Account;
use Illuminate\Http\Request;

class LossController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $accounts = Account::leftJoin('currencies','accounts.default_currency','=','currencies.id')->orderBy('accounts.id', 'desc')
        ->select('*','accounts.id as actId')->where('accounts.is_active','1')->get();
        $values = loss::leftJoin('users', 'losses.user_id', '=', 'users.id')->orderBy('losses.id', 'desc')
        ->leftJoin('accounts','losses.account_id','=','accounts.id')
        ->select('*','losses.id as LId')->get();
        return view('forex.losses', compact('values','accounts'));
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

            'reff_number'=> 'required',
            'account_id',
            'description'=> 'required',
            'loss_amount'=> 'required',
            'type'=> 'required',

            ]);
        $value = new loss();
        $value->reff_number = $request->input('reff_number');
        $value->account_id = $request->input('account_id');
        $value->description = $request->input('description');
        $value->loss_amount= $request->input('loss_amount');
        $value->type = $request->input('type');
        $value->loss_year = date("Y");
        $value->loss_month = date("M-Y");
        $value->loss_week = date("Y-M-W");
        $value->date_added = date('Y-m-d');
        $value->user_id =  auth()->user()->id;
        $value->save();

         return  redirect()->back()->with('success', 'Loss Successfully added !!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\loss  $loss
     * @return \Illuminate\Http\Response
     */
    public function show(loss $loss)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\loss  $loss
     * @return \Illuminate\Http\Response
     */
    public function edit(loss $loss)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\loss  $loss
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, loss $loss)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\loss  $loss
     * @return \Illuminate\Http\Response
     */
    public function destroy(loss $id)
    {
        $id->delete();
        return redirect()->back()->with('success', 'Record was deleted successfully !!');
    }
}
