<?php

namespace App\Http\Controllers;

use App\Models\Transfer;
use App\Models\Account;
use App\Models\Currency;
use App\Models\Expenditure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $values = Transfer::leftJoin('users', 'transfers.user_id', '=', 'users.id')->orderBy('transfers.id', 'desc')
        ->select('*','transfers.id as TId')->get();
        return view('forex.transfers', compact('values'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $id)
    {
        $currencies = Currency::orderBy('currency_name', 'asc')->where('is_active','1')->get();
        $code = $request->route('id'); //getting the request code
        $accounts = Account::leftJoin('currencies','accounts.default_currency','=','currencies.id')->orderBy('accounts.id', 'desc')
        ->select('*','accounts.id as actId')->where('accounts.is_active','1')->get();
        return view('forex.newTransfer', compact('accounts','code','currencies'));
    }
    public function getAcct1(Request $request){

        $itemData['data'] = Account::leftJoin('currencies','accounts.default_currency','=','currencies.id')
        ->select('available_balance', 'usd_exrate','account_number')
        			->where('accounts.id',$request->act_id)
        			->get();

        return response()->json($itemData);

    }
    public function getAcct2(Request $request){

        $itemData['data'] = Account::leftJoin('currencies','accounts.default_currency','=','currencies.id')
        ->select('available_balance', 'usd_exrate','account_number')
        			->where('accounts.id',$request->act_id)
        			->get();

        return response()->json($itemData);

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
        'reff_number'=>'required',
        'from_acct'=>'required',
        'from_id'=>'required',
        'to_acct'=>'required',
        'to_id'=>'required',
        'total_amount'=>'required',
        'trans_charges'=>'required',
        'date_added'=>'required',
        ]);
        $reff = 'T'.mt_rand(1000, 9999).time();
        $value = new Transfer();
        $value->reff_number = $reff;
        $value->from_acct = $request->input('from_acct');
        $value->from_id = $request->input('from_id');
        $value->to_acct= $request->input('to_acct');
        $value->to_id = $request->input('to_id');
        $value->initial_amount= $request->input('ex_amount');
        $value->total_amount= $request->input('total_amount');
        $value->trans_charges= $request->input('trans_charges');
        //$value->ex_amount = $request->input('ex_amount');
        $value->type = 'Money Transfer';
        $value->trans_year = date("Y");
        $value->trans_month = date("M-Y");
        $value->trans_week = date("Y-M-W");
        $value->date_added = $request->input('date_added');
        $value->user_id =  auth()->user()->id;
        $value->save();
        $diffAmt = $request->input('total_amount');
        $addAmt = $request->input('ex_amount');
        Account::where('id', $request->input('to_id'))->update(['available_balance' => DB::raw('available_balance + '.$diffAmt)]);
        Account::where('id', $request->input('from_id'))->update(['available_balance' => DB::raw('available_balance - '.$diffAmt)]);

        $value = new Expenditure();
        $value->reff_number = $reff;
        $value->from_acct = $request->input('from_acct');
        $value->description = 'Inter account transfer charges';
        $value->exp_amount= $request->input('trans_charges');
        $value->type = 'Money Transfer';
        $value->exp_year = date("Y");
        $value->exp_month = date("M-Y");
        $value->exp_week = date("Y-M-W");
        $value->date_added = date('Y-m-d');
        $value->user_id =  auth()->user()->id;
        $value->save();

         return  redirect('forex/accounts/transfers')->with('success', 'Transfer Successfully added !!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transfer  $transfer
     * @return \Illuminate\Http\Response
     */
    public function show(Transfer $transfer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transfer  $transfer
     * @return \Illuminate\Http\Response
     */
    public function edit(Transfer $transfer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transfer  $transfer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transfer $transfer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transfer  $transfer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transfer $transfer)
    {
        //
    }
}
