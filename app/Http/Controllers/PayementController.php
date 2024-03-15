<?php

namespace App\Http\Controllers;

use App\Models\Payement;
use Illuminate\Http\Request;
use App\Models\customer;
use App\Models\supplier;
use App\Models\Account;
use Faker\Provider\ar_SA\Payment;
use Illuminate\Support\Facades\DB;

class PayementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $received =  Payement::where('type','receive')->sum('total_amount');
        $made =  Payement::where('type','pay')->sum('total_amount');
        $credits = customer::sum('balance');
        $loan = supplier::sum('balance');
        $values = Payement::leftJoin('users', 'payements.user_id', '=', 'users.id')->orderBy('payements.id', 'desc')
        ->leftJoin('accounts', 'payements.from_id', '=','accounts.id')
        ->select('*','payements.id as PId')->get();
        return view('forex.payments', compact('values','received','made','credits','loan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function make()
    {
        $suppliers = supplier::where('balance','>',0)->orderBy('id', 'desc')->get();
        $accounts = Account::leftJoin('currencies','accounts.default_currency','=','currencies.id')->orderBy('accounts.id', 'desc')
        ->select('*','accounts.id as actId')->where('accounts.is_active','1')->get();
        return view('forex.newMakePayment', compact('accounts','suppliers'));
    }
    public function getSupp(Request $request){

        $itemData['data'] = supplier::where('id',$request->sup_id)->select('balance', 'sup_name')->get();

        return response()->json($itemData);

    }

    public function receive()
    {
        $customers = customer::where('balance','<',0)->orderBy('id', 'desc')->get();
        $accounts = Account::leftJoin('currencies','accounts.default_currency','=','currencies.id')->orderBy('accounts.id', 'desc')
        ->select('*','accounts.id as actId')->where('accounts.is_active','1')->get();
        return view('forex.newGetPayment', compact('accounts','customers'));
    }
    public function getcust(Request $request){

        $itemData['data'] = customer::where('id',$request->sup_id)->select('balance', 'cust_name')->get();

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
        if($request->input('total_amount')>0){
        $request->validate([
            'reff_number'=>'required',
            'from_acct'=>'required',
             'from_id'=>'required',
            'to_acct'=>'required',
            'to_name'=>'required',
            'total_amount'=>'required',
            'date_added'=>'required',
        ]);
        $value = new Payement();
        $value->reff_number = $request->input('reff_number');
        $value->from_acct = $request->input('from_acct');
        $value->from_id = $request->input('from_id');
        $value->to_acct = $request->input('to_acct');
        $value->to_name = $request->input('to_name');
        $value->total_amount = $request->input('total_amount');
        $value->trans_charges = 0;
        $value->type = 'pay';
        $value->trans_year = date("Y");
        $value->trans_month = date("M-Y");
        $value->trans_week = date("Y-M-W");
        $value->date_added = $request->input('date_added');
        $value->user_id =  auth()->user()->id;
        $value->save();
        $diffAmt = $request->input('total_amount');
        Account::where('id', $request->input('from_id'))->update(['available_balance' => DB::raw('available_balance - '.$diffAmt)]);
        supplier::where('id', $request->input('to_acct'))->update(['balance' => DB::raw('balance - '.$diffAmt)]);
        return  redirect('forex/payments')->with('success', 'Supplier was Successfully payed !!');
    }
    else{
        return  redirect()->back()->with('error', 'Amount paid must be greater than 0 !!');
    }
    }

    public function store2(Request $request)
    {
        if($request->input('total_amount')>0){
        $request->validate([
            'reff_number'=>'required',
            'from_acct'=>'required',
             'from_id'=>'required',
            'to_acct'=>'required',
            'to_name'=>'required',
            'total_amount'=>'required',
            'date_added'=>'required',
        ]);
        $value = new Payement();
        $value->reff_number = $request->input('reff_number');
        $value->from_acct = $request->input('from_acct');
        $value->from_id = $request->input('from_id');
        $value->to_acct = $request->input('to_acct');
        $value->to_name = $request->input('to_name');
        $value->total_amount = $request->input('total_amount');
        $value->trans_charges = 0;
        $value->type = 'receive';
        $value->trans_year = date("Y");
        $value->trans_month = date("M-Y");
        $value->trans_week = date("Y-M-W");
        $value->date_added = $request->input('date_added');
        $value->user_id =  auth()->user()->id;
        $value->save();
        $diffAmt = $request->input('total_amount');
        Account::where('id', $request->input('to_acct'))->update(['available_balance' => DB::raw('available_balance + '.$diffAmt)]);
        customer::where('id', $request->input('from_id'))->update(['balance' => DB::raw('balance + '.$diffAmt)]);
        return  redirect('forex/payments')->with('success', 'Customer Payemt was Successfully received !!');
    }
    else{
        return  redirect()->back()->with('error', 'Amount paid must be greater than 0 !!');
    }
    }
        public function destroyPay(Request $request)
    {
        
       
            $request->validate([
                'reff_number'=> 'required',
                'to_acct'=> 'required',
                'customer_id'=> 'required|numeric',
                ]);
                $diffAmt = $request->input('total_amount');
                Account::where('id', $request->input('to_acct'))->update(['available_balance' => DB::raw('available_balance - '.$diffAmt)]);
                customer::where('id', $request->input('customer_id'))->update(['balance' => DB::raw('balance - '.$diffAmt)]);

                   
        Payement::where('reff_number',$request->input('reff_number'))->delete();
        return  redirect('forex/payments')->with('success', 'Payment Successfully deleted !!');
    }

    public function destroyLoan(Request $request)
    {  
       
            $request->validate([
                'reff_number'=> 'required',
                'to_acct'=> 'required|numeric',
                'from_id'=> 'required|numeric',
                ]);
                
                $diffAmt = $request->input('total_amount');
                Account::where('id', $request->input('from_id'))->update(['available_balance' => DB::raw('available_balance + '.$diffAmt)]);
                supplier::where('id', $request->input('to_acct'))->update(['balance' => DB::raw('balance + '.$diffAmt)]);
                   
        Payement::where('reff_number',$request->input('reff_number'))->delete();
        return  redirect('forex/payments')->with('success', 'Suppliers Payment Successfully deleted !!');
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Payement  $payement
     * @return \Illuminate\Http\Response
     */
    public function show(Payement $payement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Payement  $payement
     * @return \Illuminate\Http\Response
     */
    public function edit(Payement $payement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Payement  $payement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payement $payement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Payement  $payement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payement $payement)
    {
        //
    }
}
