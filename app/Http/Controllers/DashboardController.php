<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Currency;
use App\Models\customer;
use App\Models\Payement;
use App\Models\supplier;
use App\Models\Transfer;
use App\Models\Expenditure;
use App\Models\Transactions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\capitalTransactions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tdate = date('Y-m-d');
        $syear = date("Y");
        $smonth = date("M-Y");
        $sweek = date("Y-M-W");
        $TotalAcounts = Account::count('id');
        $Totalsales =Transactions::where('t_type','sale')->sum('total_amount');
        $TotalCashsales =Transactions::where('sale_type','Cash')->sum('total_amount');
        $TotalCreditsales =Transactions::where('sale_type','Credit')->sum('total_amount');
        $TotalsalesDaily =Transactions::where('t_type','sale')->where('date_added', $tdate)->sum('total_amount');
        $TotalsalesWeekly =Transactions::where('t_type','sale')->where('trans_week', $sweek)->sum('total_amount');
        $TotalsalesMonthly =Transactions::where('t_type','sale')->where('trans_month', $smonth)->sum('total_amount');
        $TotalsalesYearly =Transactions::where('t_type','sale')->where('trans_year', $syear)->sum('total_amount');

        DB::statement("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));");
        $TotalsalesByCur =Transactions::where('t_type','sale')
        ->leftJoin('currencies','transactions.currency_id','=','currencies.id')
        ->groupBy(['currency_id'])->select('currency_name','currency_country', DB::raw('sum(total_amount) as totalamount'))->get();

        $TotalsalesByAcct =Transactions::where('t_type','sale')
        ->leftJoin('accounts','transactions.from_id','=','accounts.id')
        ->groupBy(['from_id'])->select('account_name','account_number', DB::raw('sum(total_amount) as totalamount'))->paginate(8);

        $Totalsalesbar =Transactions::where('t_type','sale')
        ->groupBy(['trans_month'])->select('trans_month', DB::raw('sum(total_amount) as totalamount'))
        ->limit(12)->get();

        $Totalsalesday =Transactions::where('t_type','sale')
        ->groupBy(['date_added'])->select('date_added', DB::raw('sum(total_amount) as totalamount'))
        ->limit(5)->get();

        $Expenses =Expenditure::groupBy(['date_added'])->select('date_added', DB::raw('sum(exp_amount) as totalamount'))
        ->limit(5)->get();

        if (count($Totalsalesbar)>0){
        foreach($Totalsalesbar as $data){
            $month[] = $data->trans_month;
            $amount[] = $data->totalamount;
           }
           $month= json_encode($month,JSON_NUMERIC_CHECK);
            $amount = json_encode($amount,JSON_NUMERIC_CHECK);
        }else{
                $month="0";
                $amount="0";

            }

            if (count($Totalsalesday)>0){
            foreach($Totalsalesday as $data){
                $dmonth[] = $data->date_added;
                $damount[] = $data->totalamount;
                }
                $dmonth= json_encode($dmonth,JSON_NUMERIC_CHECK);
                $damount = json_encode($damount,JSON_NUMERIC_CHECK);
            }else{
                    $dmonth="0";
                    $damount="0";

                }

                if (count($Expenses)>0){
                    foreach($Expenses as $data){
                        $emonth[] = $data->date_added;
                        $eamount[] = $data->totalamount;
                        }
                        $emonth= json_encode($emonth,JSON_NUMERIC_CHECK);
                        $eamount = json_encode($eamount,JSON_NUMERIC_CHECK);
                    }else{
                            $emonth="0";
                            $eamount="0";

                        }
        //return $Totalsalesbar;

        DB::statement("SET sql_mode=(SELECT CONCAT(@@sql_mode, ',ONLY_FULL_GROUP_BY'));");
        return view('forex.dashboard', compact('eamount','emonth','damount','dmonth','amount','month','TotalsalesByAcct','TotalsalesByCur','TotalsalesYearly','TotalsalesMonthly','TotalsalesWeekly','TotalsalesDaily','TotalAcounts','Totalsales','TotalCashsales','TotalCreditsales'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function reset()
    {
        if(Auth::user()->hasPermission(['operations-delete'])){
        DB::statement("SET foreign_key_checks=0");
        // Currency::truncate();
        // Account::truncate();
        // Expenditure::truncate();
        // Transactions::truncate();
        // Transfer::truncate();
        // customer::truncate();
        // supplier::truncate();
        // Payement::truncate();
        // capitalTransactions::truncate();
        DB::statement("TRUNCATE capital_transactions;");
        //  DB::statement("TRUNCATE currencies;"); 
         DB::statement("TRUNCATE expenditures;"); 
         DB::statement("TRUNCATE losses;"); 
         DB::statement("TRUNCATE payements;"); 
         DB::statement("TRUNCATE rate_logs;"); 
         DB::statement("TRUNCATE transactions;"); 
         DB::statement("TRUNCATE transfers;");
         DB::statement("UPDATE suppliers SET balance = '0'");
         DB::statement("UPDATE customers SET balance = '0' ");
         DB::statement("UPDATE currencies SET selling_rate = 0, buying_rate = 0, usd_exrate = 0;");
         DB::statement("UPDATE accounts SET available_balance = '0', foreign_amount = 0;");
        DB::statement("SET foreign_key_checks=1");
        return redirect('forex/dashboard')->with('success', 'All Records where successfully deleted !!');}else{
            return redirect('forex/dashboard')->with('error', 'you have no permission to clear these records !!');
        }
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
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
