<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\capitalTransactions;
use App\Models\Currency;
use App\Models\Forex\RateLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class CapitalTransactionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $values = capitalTransactions::leftJoin('users', 'capital_transactions.user_id', '=', 'users.id')
            ->leftJoin('currencies', 'capital_transactions.currency_id', '=', 'currencies.id')
            ->leftJoin('accounts', 'capital_transactions.account', '=', 'accounts.id')
            ->orderBy('capital_transactions.id', 'desc')
            ->select('*', 'capital_transactions.id as CTId')->get();
        return view('forex.capitaltransactions', compact('values'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $currencies = Currency::orderBy('currency_name', 'asc')->where('is_active', '1')->get();
        //$code = $request->route('id'); //getting the request code
        $accounts = Account::leftJoin('currencies', 'accounts.default_currency', '=', 'currencies.id')->orderBy('accounts.id', 'desc')
            ->select('*', 'accounts.id as actId')->where('accounts.is_active', '1')->get();
        return view('forex.newDeposit', compact('accounts', 'currencies'));
    }
    public function create2()
    {

        $currencies = Currency::orderBy('currency_name', 'asc')->where('is_active', '1')->get();
        //$code = $request->route('id'); //getting the request code
        $accounts = Account::leftJoin('currencies', 'accounts.default_currency', '=', 'currencies.id')->orderBy('accounts.id', 'desc')
            ->select('*', 'accounts.id as actId')->where('accounts.is_active', '1')->get();
        return view('forex.newWithdraw', compact('accounts', 'currencies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $request->validate([
                    'currency' => 'required',
                    'account' => 'required',
                    'total_amount' => 'required|numeric',
                    'total_foreign' => 'required',
                    'Description' => 'required',
                    'customer_id',
                    'charges' => 'required',
                    'rate' => 'required',
                    'date_added' => 'required',
                ]);

                $reff = 'DC' . mt_rand(1000, 9999) . time();
                $value = new capitalTransactions();
                $value->reff_number = $reff;
                $value->account = $request->input('account');
                $value->currency_id = $request->input('currency');
                $value->total_amount = $request->input('total_amount');
                $value->foreign_amount = $request->input('initial_amount');
                $value->rate = $request->input('rate');
                $value->Description = $request->input('Description');
                $value->charges = $request->input('charges');
                $value->trans_type = 'deposit';
                $value->trans_year = date("Y");
                $value->trans_month = date("M-Y");
                $value->trans_week = date("Y-M-W");
                $value->date_added = $request->input('date_added');
                $value->user_id = auth()->user()->id;
                $value->save();
                $diffAmt = round($request->input('total_amount'),2);
                $total_foreign = round($request->input('total_foreign'),2);
                $this->updateRates($request->input('rate'), $request->input('currency'));
                Account::where('id', $request->input('account'))->update(['available_balance' => DB::raw('available_balance + ' . $diffAmt), 'foreign_amount' => DB::raw('foreign_amount + ' . $total_foreign)]);

            });

            return redirect('forex/capital')->with('success', 'Deposit Successfully added !!');
        } catch (Throwable $error) {
            return redirect('forex/capital')->with('error', 'Deposit transaction !!');
        }
    }
    public function updateRates($newBuyingRate, $currency_id)
    {
        // Get the current buying rate and profit percentage
        $currency = Currency::where('id', $currency_id)->first();
        $currentBuyingRate = $currency->buying_rate;
        $currentSellingRate = $currency->selling_rate;
        $profitPercentage = $currency->percentage_rate;

        // Calculate the new average buying rate

        if ($currentBuyingRate > 0.1) {
            $newAverageBuyingRate = ($currentBuyingRate + $newBuyingRate) / 2;
        } else {
            $newAverageBuyingRate = $newBuyingRate;
        }
        // dd($newAverageBuyingRate);
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
    public function store2(Request $request)
    {
        $request->validate([
            'currency' => 'required',
            'account' => 'required',
            'total_amount' => 'required|numeric',
            'total_foreign' => 'required',
            'Description' => 'required',
            'customer_id',
            'charges' => 'required',
            'date_added' => 'required',
        ]);

        $reff = 'WC' . mt_rand(1000, 9999) . time();
        $value = new capitalTransactions();
        $value->reff_number = $reff;
        $value->account = $request->input('account');
        $value->currency_id = $request->input('currency');
        $value->total_amount = $request->input('total_amount');
        $value->foreign_amount = $request->input('total_foreign');
        $value->Description = $request->input('Description');
        $value->charges = $request->input('charges');
        $value->trans_type = 'withdraw';
        $value->trans_year = date("Y");
        $value->trans_month = date("M-Y");
        $value->trans_week = date("Y-M-W");
        $value->date_added = $request->input('date_added');
        $value->user_id = auth()->user()->id;
        $value->save();
        $diffAmt = $request->input('total_amount');
        Account::where('id', $request->input('account'))->update(['available_balance' => DB::raw('available_balance - ' . $diffAmt)]);

        return redirect('forex/capital')->with('success', 'Withdraw Successfully added !!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\capitalTransactions  $capitalTransactions
     * @return \Illuminate\Http\Response
     */
    public function show(capitalTransactions $capitalTransactions)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\capitalTransactions  $capitalTransactions
     * @return \Illuminate\Http\Response
     */
    public function edit(capitalTransactions $capitalTransactions)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\capitalTransactions  $capitalTransactions
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, capitalTransactions $capitalTransactions)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\capitalTransactions  $capitalTransactions
     * @return \Illuminate\Http\Response
     */
    public function destroy(capitalTransactions $capitalTransactions)
    {
        //
    }
}
