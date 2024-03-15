<?php

namespace App\Http\Controllers;
use App\Models\customer;
use App\Http\Controllers\Controller;
use App\Models\Payement;
use App\Models\Transactions;
use Illuminate\Http\Request;

class CustomersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $values = customer::orderBy('id', 'desc')->get();
        return view('forex.Customers')->with('values', $values);
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
        $this->validate($request,[
            'cust_name'=>'required',
            'address'=>'required',
            'contact'=>'required',
            'email'=>'required',
            'balance'=>'required|numeric'
        ]);
            $value = new customer;
            $value->balance = 0-$request->input('balance');
            $value->cust_name = $request->input('cust_name');
            $value->address = $request->input('address');
            $value->contact = $request->input('contact');
            $value->email = $request->input('email');
            //$value->branch_id = session('branchid');
            $value->user_id = auth()->user()->id;
            $value->save();
            return redirect()->back()->with('success', 'Record Successfully added !!');
        }
        
    public function storeBalance(Request $request)
    {
        $this->validate($request,[
            'customer'=>'required',
            'amount'=>'required|numeric'
        ]);
        
            $customer = customer::find($request->input('customer'));
            if($request->input('type')=='Credit'){
                $customer->balance += $request->input('amount');
            }else{
                $customer->balance -= $request->input('amount');
            }
            
            $customer->save();
            
            return redirect()->back()->with('success', 'Record Successfully added !!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
       public function show($id)
    {
        $received =  Payement::where('type','receive')->where('from_id',$id)->sum('total_amount');
        $cash =  Transactions::where('t_type','sale')->where('transactions.customer_id',$id)->sum('total_amount');
        $credits = customer::where('id',$id)->sum('balance');
        $customer = customer::where('id',$id)->first();
        $values = Payement::leftJoin('users', 'payements.user_id', '=', 'users.id')->orderBy('payements.id', 'desc')
        ->leftJoin('accounts', 'payements.from_id', '=','accounts.id')
        ->select('*','payements.id as PId')->where('from_id',$id)->orderBy('payements.date_added','DESC')->get();
        return view('forex.custpayments', compact('values','received','credits','customer','cash'));
    }
    public function show2($id)
    {
        $received =  Payement::where('type','receive')->where('from_id',$id)->sum('total_amount');
        $cash =  Transactions::where('t_type','sale')->where('transactions.customer_id',$id)->sum('total_amount');
        $credits = customer::where('id',$id)->sum('balance');
        $customer = customer::where('id',$id)->first();
        $values = Transactions::leftJoin('users', 'transactions.user_id', '=', 'users.id')
        ->leftJoin('customers','transactions.customer_id', '=','customers.id' )
        ->leftJoin('currencies','transactions.currency_id','=','currencies.id')
        ->leftJoin('accounts','transactions.to_id','=','accounts.id')
        ->where('transactions.customer_id',$id)
        ->select('*','transactions.id as TId')->orderBy('transactions.date_added','DESC')->get();
        
        return view('forex.custsales', compact('values','received','credits','customer','cash'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'cust_name'=>'required',
            'address'=>'required',
            'contact'=>'required',
            'email'=>'required',
            'isActive'=>'required'
        ]);
            $value = customer::find($id);
            $value->cust_name = $request->input('cust_name');
            $value->address = $request->input('address');
            $value->contact = $request->input('contact');
            $value->email = $request->input('email');
            $value->is_active = $request->input('isActive');
            $value->update();
            return redirect()->back()->with('success', 'Record Successfully updated !!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $value = customer::find($id);
        $value->delete();
        return redirect()->back()->with('success', 'Record deleted successfully !!');
    }
}
