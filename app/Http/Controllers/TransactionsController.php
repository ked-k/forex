<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Currency;
use App\Models\customer;
use App\Models\Forex\RateLog;
use App\Models\supplier;
use App\Models\Transactions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $values = Transactions::leftJoin('users', 'transactions.user_id', '=', 'users.id')
            ->leftJoin('customers', 'transactions.customer_id', '=', 'customers.id')
            ->leftJoin('currencies', 'transactions.currency_id', '=', 'currencies.id')
            ->leftJoin('accounts', 'transactions.to_id', '=', 'accounts.id')
            ->orderBy('transactions.date_added', 'desc')
            ->select('*', 'transactions.id as TId')->get();
        return view('forex.transactions', compact('values'));
    }

    public function sales()
    {
        $values = Transactions::leftJoin('users', 'transactions.user_id', '=', 'users.id')
            ->leftJoin('customers', 'transactions.customer_id', '=', 'customers.id')
            ->leftJoin('currencies', 'transactions.currency_id', '=', 'currencies.id')
            ->leftJoin('accounts', 'transactions.to_id', '=', 'accounts.id')
            ->orderBy('transactions.date_added', 'desc')
            ->select('*', 'transactions.id as TId')
            ->where('t_type', 'sale')
            ->get();
        return view('forex.transactionSales', compact('values'));
    }

    public function purchases()
    {
        $values = Transactions::leftJoin('users', 'transactions.user_id', '=', 'users.id')
            ->leftJoin('suppliers', 'transactions.supplier_id', '=', 'suppliers.id')
            ->leftJoin('currencies', 'transactions.currency_id', '=', 'currencies.id')
            ->leftJoin('accounts', 'transactions.to_id', '=', 'accounts.id')
            ->orderBy('transactions.date_added', 'desc')
            ->select('*', 'transactions.id as TId')
            ->where('t_type', 'purchase')
            ->get();
        return view('forex.transactionPurchases', compact('values'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $id)
    {
        $customers = customer::orderBy('cust_name', 'asc')->get();
        $currencies = Currency::orderBy('currency_name', 'asc')->where('is_active', '1')->get();
        $code = $request->route('id'); //getting the request code
        $accounts = Account::leftJoin('currencies', 'accounts.default_currency', '=', 'currencies.id')->orderBy('accounts.id', 'desc')
            ->select('*', 'accounts.id as actId')->where('accounts.is_active', '1')->get();
        return view('forex.newSale', compact('accounts', 'code', 'currencies', 'customers'));
    }

    public function create2(Request $request, $id)
    {
        $suppliers = supplier::orderBy('sup_name', 'asc')->get();
        $currencies = Currency::orderBy('currency_name', 'asc')->where('is_active', '1')->get();
        $code = $request->route('id'); //getting the request code
        $accounts = Account::leftJoin('currencies', 'accounts.default_currency', '=', 'currencies.id')->orderBy('accounts.id', 'desc')
            ->select('*', 'accounts.id as actId')->where('accounts.is_active', '1')->get();
        return view('forex.newPurchase', compact('accounts', 'code', 'currencies', 'suppliers'));
    }

    public function getAccts(Request $request)
    {

        $itemData['data'] = Account::leftJoin('currencies', 'accounts.default_currency', '=', 'currencies.id')
            ->select('available_balance', 'account_name', 'accounts.id as Aid', 'account_number', 'currencies.selling_rate as salerate', 'currencies.buying_rate as buyrate')
            ->where('accounts.default_currency', $request->cur_id)
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
        DB::transaction(function () use ($request) {
        if ($request->input('sale_type') == 'Credit') {

            $request->validate([
                'reff_number',
                'from_acct' => 'required',
                'from_id' => 'required',
                'to_acct',
                'to_id',
                'currency' => 'required',
                'rate' => 'required',
                'rate2' => 'required',
                'total_amount' => 'required|numeric',
                'total_foreign' => 'required',
                'sale_type' => 'required',
                'customer_id',
                'charges' => 'required',
                'date_added' => 'required',
            ]);
        } else {
            $request->validate([
                'reff_number',
                'from_acct' => 'required',
                'from_id' => 'required',
                'to_acct',
                'to_id' => 'required',
                'currency' => 'required',
                'rate' => 'required',
                'rate2' => 'required',
                'total_amount' => 'required|numeric',
                'total_foreign' => 'required',
                'sale_type' => 'required',
                'customer_id',
                'charges' => 'required',
                'date_added' => 'required',
            ]);
        }
        $year = date('Y', strtotime($request->input('date_added')));
        $week = date('Y-M-W', strtotime($request->input('date_added')));
        $month = date('M-Y', strtotime($request->input('date_added')));

        $reff = 'TRA' . mt_rand(1000, 9999) . time();
        $value = new Transactions();
        $value->reff_number = $reff;
        $value->from_acct = $request->input('from_acct');
        $value->from_id = $request->input('from_id');
        $value->to_acct = $request->input('to_acct');
        $value->to_id = $request->input('to_id');
        $value->currency_id = $request->input('currency');
        $value->rate = $request->input('rate');
        $value->b_rate = $request->input('rate2');
        $value->total_amount = $request->input('total_amount');
        $value->foreign_amount = $request->input('total_foreign');
        $value->charges = $request->input('charges');
        $value->sale_type = $request->input('sale_type');
        $value->customer_id = $request->input('customer_id');
        $value->t_type = 'sale';
        $value->trans_year = $year;
        $value->trans_month = $month;
        $value->trans_week = $week;
        $value->date_added = $request->input('date_added');
        $value->user_id = auth()->user()->id;
        $value->save();
        $diffAmt = $request->input('total_amount');
        $mytype = $request->input('sale_type');

        $sale = Account::where('id', $request->input('from_id'))->first();
        $newBalance = $sale->available_balance - $request->input('total_foreign');
        if ($newBalance < 0) {
            $newBalance = 0;
        }
        $sale->available_balance = $newBalance;
        $sale->update();
        // ->update(['available_balance' => DB::raw('available_balance - '.$diffAmt)]);
        if ($mytype == 'Credit') {
            customer::where('id', $request->input('customer_id'))->update(['balance' => DB::raw('balance - ' . $diffAmt)]);

        } else {
            Account::where('id', $request->input('to_id'))->update(['available_balance' => DB::raw('available_balance + ' . $diffAmt)]);
        }
    });
        return redirect('forex/transactions/sales')->with('success', 'Transfer Successfully added !!');
    }

    public function store2(Request $request)
    {
        DB::transaction(function () use ($request) {
            if ($request->input('sale_type') == 'Purchase_paid') {
                $request->validate([
                    'reff_number',
                    'from_acct' => 'required',
                    'from_id' => 'required',
                    'to_acct',
                    'to_id' => 'required',
                    'currency' => 'required',
                    'rate' => 'required',
                    'total_amount' => 'required|numeric',
                    'total_foreign' => 'required',
                    'sale_type' => 'required',
                    'customer_id',
                    'charges' => 'required',
                    'date_added' => 'required',
                ]);

            } else {
                $request->validate([
                    'reff_number',
                    'from_acct',
                    'from_id',
                    'to_acct',
                    'to_id' => 'required',
                    'currency' => 'required',
                    'rate' => 'required',
                    'total_amount' => 'required|numeric',
                    'total_foreign' => 'required',
                    'sale_type' => 'required',
                    'customer_id' => 'required',
                    'charges' => 'required',
                    'date_added' => 'required',
                ]);

            }

            $year = date('Y', strtotime($request->input('date_added')));
            $week = date('Y-M-W', strtotime($request->input('date_added')));
            $month = date('M-Y', strtotime($request->input('date_added')));
            $reff = 'TRA' . mt_rand(1000, 9999) . time();
            $value = new Transactions();
            $value->reff_number = $reff;
            $value->from_acct = $request->input('from_acct');
            $value->from_id = $request->input('from_id');
            $value->to_acct = $request->input('to_acct');
            $value->to_id = $request->input('to_id');
            $value->currency_id = $request->input('currency');
            $value->rate = $request->input('rate');
            $value->total_amount = $request->input('total_amount');
            $value->foreign_amount = $request->input('total_foreign');
            $value->charges = $request->input('charges');
            $value->sale_type = $request->input('sale_type');
            $value->supplier_id = $request->input('customer_id');
            $value->t_type = 'purchase';
            $value->trans_year = $year;
            $value->trans_month = $month;
            $value->trans_week = $week;
            $value->date_added = $request->input('date_added');
            $value->user_id = auth()->user()->id;
            $value->save();
            $diffAmt = $request->input('total_amount');
            $mytype = $request->input('sale_type');
            $total_foreign = $request->input('initial_amount');
            $this->updateRates($request->input('rate'), $request->input('currency'));
            Account::where('id', $request->input('to_id'))->update(['available_balance' => DB::raw('available_balance + ' . $diffAmt), 'foreign_amount' => DB::raw('foreign_amount + ' . $total_foreign)]);

            if ($mytype == 'Purchase_credit') {
                supplier::where('id', $request->input('customer_id'))->update(['balance' => DB::raw('balance + ' . $total_foreign)]);

            } elseif ($mytype == 'Purchase_paid') {
                $buyingAccount = Account::where('id', $request->input('from_id'))->first();
                // $rate = Currency::where('id', $buyingAccount->default_currency)->first()->buying_rate;
                $total = $request->input('initial_amount');
                $buyingAccount->update(['available_balance' => DB::raw('available_balance - ' . $total), 'foreign_amount' => DB::raw('foreign_amount - ' . $total)]);

            }

        });
        return redirect('forex/transactions/purchases')->with('success', 'Purcase Successfully added !!');
    }
    public function updateRates($newBuyingRate, $currency_id)
    {
        // Get the current buying rate and profit percentage
        $currency = Currency::where('id', $currency_id)->first();
        $currentBuyingRate = $currency->buying_rate;
        $currentSellingRate = $currency->selling_rate;
        $profitPercentage = $currency->usd_exrate;

        // Calculate the new average buying rate
        if ($currentBuyingRate > 1) {
            $newAverageBuyingRate = ($currentBuyingRate + $newBuyingRate) / 2;
        } else {
            $newAverageBuyingRate = $newBuyingRate;
        }
        // Calculate the new selling rate based on profit percentage
        $newSellingRate = $newAverageBuyingRate + ($newAverageBuyingRate * $profitPercentage / 100);

        // Update the rates
        $currency->buying_rate = $newAverageBuyingRate;
        $currency->selling_rate = $newSellingRate;
        $currency->save();

        $log = new RateLog();
        $log->currency_id = $currency->id;
        $log->buying_rate = $newAverageBuyingRate;
        $log->old_buying_rate = $currentBuyingRate;
        $log->selling_rate = $newSellingRate;
        $log->old_selling_rate = $currentSellingRate;
        $log->save();
    }
    public function destroypurchase(Request $request)
    {
        $diffAmt = $request->input('total_amount');
        if ($request->input('sale_type') == 'Purchase_paid') {
            $request->validate([
                'reff_number' => 'required',
                'to_id' => 'required',
                'from_id' => 'required',
                'total_amount' => 'required',
                'sale_type' => 'required',
            ]);
            Account::where('id', $request->input('from_id'))->update(['available_balance' => DB::raw('available_balance + ' . $diffAmt)]);
            Account::where('id', $request->input('to_id'))->update(['available_balance' => DB::raw('available_balance - ' . $diffAmt)]);
        } elseif ($request->input('sale_type') == 'Purchase_credit') {
            $request->validate([
                'reff_number' => 'required',
                'to_id' => 'required',
                'total_amount' => 'required',
                'sale_type' => 'required',
                'supplier_id' => 'required',
            ]);
            Account::where('id', $request->input('to_id'))->update(['available_balance' => DB::raw('available_balance - ' . $diffAmt)]);
            supplier::where('id', $request->input('supplier_id'))->update(['balance' => DB::raw('balance - ' . $diffAmt)]);

        }

        Transactions::where('reff_number', $request->input('reff_number'))->delete();
        return redirect('forex/transactions/purchases')->with('success', 'Purcase Successfully deleted !!');
    }
    public function destroysale(Request $request)
    {
        $diffAmt = $request->input('total_amount');
        $mytype = $request->input('sale_type');
        if ($mytype == 'Credit') {
            $request->validate([
                'reff_number' => 'required',
                'from_id' => 'required',
                //'to_id'=> 'required',
                'total_amount' => 'required|numeric',
                'customer_id' => 'required|numeric',
            ]);
            customer::where('id', $request->input('customer_id'))->update(['balance' => DB::raw('balance + ' . $diffAmt)]);
            //Account::where('id', $request->input('to_id'))->update(['available_balance' => DB::raw('available_balance - '.$diffAmt)]);
            Account::where('id', $request->input('from_id'))->update(['available_balance' => DB::raw('available_balance + ' . $diffAmt)]);

        } elseif ($mytype == 'Cash') {
            $request->validate([
                'reff_number' => 'required',
                'from_id' => 'required',
                'to_id' => 'required',
                'total_amount' => 'required|numeric',
            ]);
            Account::where('id', $request->input('to_id'))->update(['available_balance' => DB::raw('available_balance - ' . $diffAmt)]);
            Account::where('id', $request->input('from_id'))->update(['available_balance' => DB::raw('available_balance + ' . $diffAmt)]);
        }

        Transactions::where('reff_number', $request->input('reff_number'))->delete();
        return redirect('forex/transactions/sales')->with('success', 'Sale Successfully deleted !!');
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transactions  $transactions
     * @return \Illuminate\Http\Response
     */
    public function show(Transactions $transactions)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transactions  $transactions
     * @return \Illuminate\Http\Response
     */
    public function edit(Transactions $transactions)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transactions  $transactions
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transactions $transactions)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transactions  $transactions
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transactions $transactions)
    {
        //
    }
}
