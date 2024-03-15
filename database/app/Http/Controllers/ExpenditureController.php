<?php

namespace App\Http\Controllers;

use App\Models\Expenditure;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExpenditureController extends Controller
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
        $values = Expenditure::leftJoin('users', 'expenditures.user_id', '=', 'users.id')
        ->leftJoin('accounts','expenditures.from_acct', '=','accounts.id')
        ->leftJoin('currencies','accounts.default_currency','=','currencies.id')
        ->orderBy('expenditures.id', 'desc')
        ->where('exp_amount','>',0)
        ->select('*','expenditures.id as EId')->get();
        return view('forex.expenditures', compact('values','accounts'));
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
        //
        $request->validate([
       'reff_number'=>'required',
       'from_acct'=>'required',
       'description'=>'required',
        'exp_amount'=>'required',
       'type'=>'required',
       'date_added'=>'required'
        ]);
          $year = date('Y', strtotime($request->input('date_added')));
        $week = date('Y-M-W', strtotime($request->input('date_added')));
        $month = date('M-Y', strtotime($request->input('date_added')));
        
        $value = new Expenditure();
        $value->reff_number = $request->input('reff_number');
        $value->from_acct = $request->input('from_acct');
        $value->description = $request->input('description');
        $value->exp_amount= $request->input('exp_amount');
        $value->type = $request->input('type');
        $value->exp_year = $year;
        $value->exp_month = $month;
        $value->exp_week = $week;
        $value->date_added = $request->input('date_added');
        $value->user_id =  auth()->user()->id;
        $value->save();
        $diffAmt = $request->input('exp_amount');
        Account::where('id', $request->input('from_acct'))->update(['available_balance' => DB::raw('available_balance - '.$diffAmt)]);
        return  redirect()->back()->with('success', 'Expense Successfully added !!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Expenditure  $expenditure
     * @return \Illuminate\Http\Response
     */
    public function show(Expenditure $expenditure)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Expenditure  $expenditure
     * @return \Illuminate\Http\Response
     */
    public function edit(Expenditure $expenditure)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Expenditure  $expenditure
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Expenditure $expenditure)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Expenditure  $expenditure
     * @return \Illuminate\Http\Response
     */
    public function destroy(Expenditure $expenditure)
    {
        //
    }
}
