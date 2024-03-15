<?php

namespace App\Http\Controllers;
use App\Models\Transactions;
use App\Models\Transfer;
use App\Models\Account;
use App\Models\Currency;
use App\Models\customer;
use App\Models\supplier;
use App\Models\Expenditure;
use App\Models\User;
use App\Models\loss;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $customers = customer::all();
        $currency = Currency::all();
        $accounts = Account::leftJoin('currencies','accounts.default_currency','=','currencies.id')->select('*','accounts.id as act')->get();
        $supplier = supplier::all();
        $users = User::all();

        return view('forex.reports', compact('customers','currency','accounts','supplier','users'));
    }

    public function dailysales(Request $request)
    {
        DB::statement("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));");
        $this->validate($request,[
            'acct'=>'required',
            'cur'=>'required'
        ]);

        $item = $request->input('acct');
        $to = $request->input('to');
        $from = $request->input('from');
        $sale = $request->input('cur');
          if ( $item == 0 and $sale == 0)
          {
            $values= Transactions::where('t_type','sale')
            ->leftJoin('accounts','transactions.from_id','=','accounts.id')
            ->select('transactions.date_added as date', DB::raw('sum(total_amount) as totalamount'))
            ->whereBetween('transactions.date_added', [$from, $to])
            ->groupBy('transactions.date_added')
            //->groupBy('Transactionss.item_id')
            ->get();
            $dpt = "All";
            $user = "All";
            $item ="All";
            $sale ="All";
            $disp="";
            $userDis="";
            return view('forex.reports.reportDaily', compact('values','dpt','user','item','disp','userDis','to','from','sale'));
          }
          elseif( $item == 0 and $sale != 0)
          {
            $values= Transactions::where('t_type','sale')
            ->leftJoin('accounts','transactions.from_id','=','accounts.id')
            ->select('transactions.date_added as date', DB::raw('sum(total_amount) as totalamount'))
            ->where('currency_id',$sale)
            ->whereBetween('transactions.date_added', [$from, $to])
            ->groupBy('transactions.date_added')
            //->groupBy('Transactionss.item_id')
            ->get();

            $dpt = "All";
            $user = "All";
            $item ="All";
            $cur = Currency::where('id',$sale)->first();
            $sale = $cur->currency_name;
            $disp="";
            $userDis="";
            return view('forex.reports.reportDaily', compact('values','dpt','user','item','disp','userDis','to','from','sale'));
          }
          elseif( $item != 0 and $sale == 0)
          {
            $values= Transactions::where('t_type','sale')
            ->leftJoin('accounts','transactions.from_id','=','accounts.id')
            ->select('transactions.date_added as date', DB::raw('sum(total_amount) as totalamount'))
            ->where('from_id',$item)
            ->whereBetween('transactions.date_added', [$from, $to])
            ->groupBy('transactions.date_added')
            //->groupBy('Transactionss.item_id')
            ->get();

            $dpt = "All";
            $user = "All";
            $act = Account::where('id',$item)->first();
            $item =$act->account_name;           
            $sale = "All";
            $disp="";
            $userDis="";
            return view('forex.reports.reportDaily', compact('values','dpt','user','item','disp','userDis','to','from','sale'));
          }
          elseif( $item != 0 and $sale != 0)
          {
            $values= Transactions::where('t_type','sale')
            ->leftJoin('accounts','transactions.from_id','=','accounts.id')
            ->select('transactions.date_added as date', DB::raw('sum(total_amount) as totalamount'))
            ->where('from_id',$item)
            ->where('currency_id',$sale)
            ->whereBetween('transactions.date_added', [$from, $to])
            ->groupBy('transactions.date_added')
            //->groupBy('Transactionss.item_id')
            ->get();
            $dpt = "All";
            $user = "All";
            $act = Account::where('id',$item)->first();
            $item =$act->account_name; 
            $cur = Currency::where('id',$sale)->first();
            $sale = $cur->currency_name;
            $disp="";
            $userDis="";
            return view('forex.reports.reportDaily', compact('values','dpt','user','item','disp','userDis','to','from','sale'));
          }
          DB::statement("SET sql_mode=(SELECT CONCAT(@@sql_mode, ',ONLY_FULL_GROUP_BY'));");
    }
    public function expenses(Request $request)
    {
        DB::statement("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));");
        $this->validate($request,[
            'expense'=>'required'
        ]);

        $item = $request->input('expense');
        $to = $request->input('to');
        $from = $request->input('from');
          if ( $item != 0 )
          {
            $values = Expenditure::leftJoin('users', 'expenditures.user_id', '=', 'users.id')
            ->leftJoin('accounts','expenditures.from_acct', '=','accounts.id')
            ->leftJoin('currencies','accounts.default_currency','=','currencies.id')
            ->orderBy('expenditures.id', 'desc')
            ->select('*','expenditures.id as EId')
            ->whereBetween('expenditures.date_added', [$from, $to])
            ->where('expenditures.type',$item)
            ->where('exp_amount','>',0)
            ->get();
            return view('forex.reports.reportExpense', compact('values','item','to','from'));
          }
        
          else
          {
            $values = Expenditure::leftJoin('users', 'expenditures.user_id', '=', 'users.id')
            ->leftJoin('accounts','expenditures.from_acct', '=','accounts.id')
            ->leftJoin('currencies','accounts.default_currency','=','currencies.id')
            ->orderBy('expenditures.id', 'desc')
            ->select('*','expenditures.id as EId')
            ->whereBetween('expenditures.date_added', [$from, $to])
            ->where('exp_amount','>',0)
            //->groupBy('expenditures.type')
            ->get();
            $item = "All";          
            return view('forex.reports.reportExpense', compact('values','item','to','from'));
          }
          DB::statement("SET sql_mode=(SELECT CONCAT(@@sql_mode, ',ONLY_FULL_GROUP_BY'));");
    }

    public function profitLoss(Request $request)
    {
        DB::statement("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));");
        $this->validate($request,[
            'acct'=>'required'
        ]);

        $item = $request->input('acct');
        $to = $request->input('to');
        $from = $request->input('from');
          if ( $item != 0 )
          {
            $expenses = Expenditure::leftJoin('accounts','expenditures.from_acct', '=','accounts.account_number')
            ->leftJoin('currencies','accounts.default_currency','=','currencies.id')
            ->groupBy('expenditures.exp_month')
            ->select('exp_month', DB::raw('sum(exp_amount) as totalamount'))
            ->whereBetween('expenditures.date_added', [$from, $to])
            ->where('accounts.id',$item)
            ->where('exp_amount','>',0)
            ->get();
            $loses = loss::leftJoin('accounts','losses.account_id','=','accounts.id')
            ->whereBetween('losses.date_added', [$from, $to])
            ->select('loss_month', DB::raw('sum(loss_amount) as totalamount'))
            ->where('losses.account_id',$item)
            ->groupBy('loss_month')->get();
            $sales= Transactions::where('t_type','sale')
            ->leftJoin('accounts','transactions.from_id','=','accounts.id')
            ->select('transactions.date_added as date','trans_month', DB::raw('sum(total_amount) as totalamount'))
            ->where('from_id',$item)
            ->whereBetween('transactions.date_added', [$from, $to])
            ->groupBy('transactions.trans_month')
            ->get();
            $purchases= Transactions::where('t_type','purchase')
            ->leftJoin('accounts','transactions.from_id','=','accounts.id')
            ->select('transactions.date_added as date','trans_month', DB::raw('sum(total_amount) as totalamount'))
            ->where('to_id',$item)
            ->whereBetween('transactions.date_added', [$from, $to])
            ->groupBy('transactions.trans_month')
            ->get();
            $act = Account::where('id',$item)->first();
            $item =$act->account_name.'-'.$act->account_number;
            return view('forex.reports.reportProfitLoss', compact('expenses','item','to','from','sales','purchases','loses'));
          }
        
          else
          {
            $expenses = Expenditure::leftJoin('accounts','expenditures.from_acct', '=','accounts.account_number')
            ->leftJoin('currencies','accounts.default_currency','=','currencies.id')
            ->groupBy('expenditures.exp_month')
            ->select('exp_month', DB::raw('sum(exp_amount) as totalamount'))
            ->whereBetween('expenditures.date_added', [$from, $to])
            //->where('accounts.id',$item)
            ->where('exp_amount','>',0)
            ->get();
            $loses = loss::leftJoin('accounts','losses.account_id','=','accounts.id')
            ->whereBetween('losses.date_added', [$from, $to])
            ->select('loss_month', DB::raw('sum(loss_amount) as totalamount'))
            //->where('losses.account_id',$item)
            ->groupBy('loss_month')->get();
            $sales= Transactions::where('t_type','sale')
            ->leftJoin('accounts','transactions.from_id','=','accounts.id')
            ->select('transactions.date_added as date','trans_month', DB::raw('sum(total_amount) as totalamount'))
            //->where('from_id',$item)
            ->whereBetween('transactions.date_added', [$from, $to])
            ->groupBy('transactions.trans_month')
            ->get();
            $purchases= Transactions::where('t_type','purchase')
            ->leftJoin('accounts','transactions.from_id','=','accounts.id')
            ->select('transactions.date_added as date','trans_month', DB::raw('sum(total_amount) as totalamount'))
            //->where('to_id',$item)
            ->whereBetween('transactions.date_added', [$from, $to])
            ->groupBy('transactions.trans_month')
            ->get();
            //$act = Account::where('id',$item)->first();
            $item ='All Accounts';
            return view('forex.reports.reportProfitLoss', compact('expenses','item','to','from','sales','purchases','loses'));
          }
          DB::statement("SET sql_mode=(SELECT CONCAT(@@sql_mode, ',ONLY_FULL_GROUP_BY'));");
    }
    public function purchases(Request $request)
    {
        DB::statement("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));");
        $this->validate($request,[
            'acct'=>'required',
            'type'=>'required'
        ]);

        $item = $request->input('acct');
        $to = $request->input('to');
        $from = $request->input('from');
        $sale = $request->input('type');
          if ( $item == 0 and $sale == 0)
          {
            $values= Transactions::where('t_type','purchase')
            ->leftJoin('accounts','transactions.to_id','=','accounts.id')
            ->leftJoin('suppliers','transactions.supplier_id', '=','suppliers.id' )
            ->leftJoin('currencies','transactions.currency_id','=','currencies.id')
            ->whereBetween('transactions.date_added', [$from, $to])            
            ->get();
            $dpt = "All";
            $user = "All";
            $item ="All";
            $sale ="All";
            $disp="";
            $userDis="";
            return view('forex.reports.reportPurchases', compact('values','dpt','user','item','disp','userDis','to','from','sale'));
          }
          elseif( $item == 0 and $sale != 0)
          {
            $values= Transactions::where('t_type','purchase')
            ->leftJoin('accounts','transactions.to_id','=','accounts.id')
            ->leftJoin('suppliers','transactions.supplier_id', '=','suppliers.id' )
            ->leftJoin('currencies','transactions.currency_id','=','currencies.id')
            ->whereBetween('transactions.date_added', [$from, $to])  
            ->where('sale_type',$sale)
            ->get();       
            $dpt = "All";
            $user = "All";
            $item ="All";
            $disp="d-none";
            $userDis="";
            return view('forex.reports.reportPurchases', compact('values','dpt','user','item','disp','userDis','to','from','sale'));
          }
          elseif( $item != 0 and $sale == 0)
          {
            $values= Transactions::where('t_type','purchase')
            ->leftJoin('accounts','transactions.to_id','=','accounts.id')
            ->leftJoin('suppliers','transactions.supplier_id', '=','suppliers.id' )
            ->leftJoin('currencies','transactions.currency_id','=','currencies.id')
            ->whereBetween('transactions.date_added', [$from, $to])  
            ->where('to_id',$item)
            ->get();

            $dpt = "All";
            $user = "All";
            $act = Account::where('id',$item)->first();
            $item =$act->account_name.' - '.$act->account_number;           
            $sale = "All";
            $disp="";
            $userDis="";
            return view('forex.reports.reportPurchases', compact('values','dpt','user','item','disp','userDis','to','from','sale'));
          }
          elseif( $item != 0 and $sale != 0)
          {
            $values= Transactions::where('t_type','purchase')
            ->leftJoin('accounts','transactions.to_id','=','accounts.id')
            ->leftJoin('suppliers','transactions.supplier_id', '=','suppliers.id' )
            ->leftJoin('currencies','transactions.currency_id','=','currencies.id')
            ->whereBetween('transactions.date_added', [$from, $to])  
            ->where('to_id',$item)
            ->where('sale_type',$sale)
            ->get();
            $dpt = "All";
            $user = "All";
            $act = Account::where('id',$item)->first();
            $item =$act->account_name.' - '.$act->account_number; 
            $disp="d-none";
            $userDis="";
            return view('forex.reports.reportPurchases', compact('values','dpt','user','item','disp','userDis','to','from','sale'));
          }
          DB::statement("SET sql_mode=(SELECT CONCAT(@@sql_mode, ',ONLY_FULL_GROUP_BY'));");
    }
    public function sales(Request $request)
    {
        DB::statement("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));");
        $this->validate($request,[
            'acct'=>'required',
            'type'=>'required'
        ]);

        $item = $request->input('acct');
        $to = $request->input('to');
        $from = $request->input('from');
        $sale = $request->input('type');
          if ( $item == 0 and $sale == 0)
          {
            $values = Transactions::leftJoin('customers','transactions.customer_id', '=','customers.id' )
            ->leftJoin('currencies','transactions.currency_id','=','currencies.id')
            ->leftJoin('accounts','transactions.to_id','=','accounts.id')
            ->orderBy('transactions.id', 'desc')
            ->select('*','transactions.id as TId')
            ->where('t_type','sale')
            ->whereBetween('transactions.date_added', [$from, $to])            
            ->get();
            $dpt = "All";
            $user = "All";
            $item ="All";
            $sale ="All";
            $disp="";
            $userDis="";
            return view('forex.reports.reportSales', compact('values','dpt','user','item','disp','userDis','to','from','sale'));
          }
          elseif( $item == 0 and $sale != 0)
          {
            $values = Transactions::leftJoin('customers','transactions.customer_id', '=','customers.id' )
            ->leftJoin('currencies','transactions.currency_id','=','currencies.id')
            ->leftJoin('accounts','transactions.to_id','=','accounts.id')
            ->orderBy('transactions.id', 'desc')
            ->select('*','transactions.id as TId')
            ->where('t_type','sale')
            ->whereBetween('transactions.date_added', [$from, $to])  
            ->where('sale_type',$sale)
            ->get();       
            $dpt = "All";
            $user = "All";
            $item ="All";
            $disp="d-none";
            $userDis="";
            return view('forex.reports.reportSales', compact('values','dpt','user','item','disp','userDis','to','from','sale'));
          }
          elseif( $item != 0 and $sale == 0)
          {
            $values = Transactions::leftJoin('customers','transactions.customer_id', '=','customers.id' )
            ->leftJoin('currencies','transactions.currency_id','=','currencies.id')
            ->leftJoin('accounts','transactions.to_id','=','accounts.id')
            ->orderBy('transactions.id', 'desc')
            ->select('*','transactions.id as TId')
            ->where('t_type','sale')
            ->whereBetween('transactions.date_added', [$from, $to])  
            ->where('from_id',$item)
            ->get();

            $dpt = "All";
            $user = "All";
            $act = Account::where('id',$item)->first();
            $item =$act->account_name.' - '.$act->account_number;           
            $sale = "All";
            $disp="";
            $userDis="";
            return view('forex.reports.reportSales', compact('values','dpt','user','item','disp','userDis','to','from','sale'));
          }
          elseif( $item != 0 and $sale != 0)
          {
            $values = Transactions::leftJoin('customers','transactions.customer_id', '=','customers.id' )
            ->leftJoin('currencies','transactions.currency_id','=','currencies.id')
            ->leftJoin('accounts','transactions.to_id','=','accounts.id')
            ->orderBy('transactions.id', 'desc')
            ->select('*','transactions.id as TId')
            ->where('t_type','sale')
            ->whereBetween('transactions.date_added', [$from, $to])  
            ->where('from_id',$item)
            ->where('sale_type',$sale)
            ->get();
            $dpt = "All";
            $user = "All";
            $act = Account::where('id',$item)->first();
            $item =$act->account_name.' - '.$act->account_number; 
            $disp="d-none";
            $userDis="";
            return view('forex.reports.reportSales', compact('values','dpt','user','item','disp','userDis','to','from','sale'));
          }
          DB::statement("SET sql_mode=(SELECT CONCAT(@@sql_mode, ',ONLY_FULL_GROUP_BY'));");
    }
       public function Customersales(Request $request)
    {
        DB::statement("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));");
        $this->validate($request,[
            'cutomer'=>'required',
            'type'=>'required'
        ]);

        $item = $request->input('cutomer');
        $to = $request->input('to');
        $from = $request->input('from');
        $sale = $request->input('type');
          if ( $item == 0 and $sale == 0)
          {
            $values = Transactions::leftJoin('customers','transactions.customer_id', '=','customers.id' )
            ->leftJoin('currencies','transactions.currency_id','=','currencies.id')
            ->leftJoin('accounts','transactions.to_id','=','accounts.id')
            ->orderBy('transactions.id', 'desc')
            ->select('*','transactions.id as TId')
            ->where('t_type','sale')
            ->whereBetween('transactions.date_added', [$from, $to])            
            ->get();
            $dpt = "All";
            $user = "All";
            $item ="All";
            $sale ="All";
            $disp="";
            $userDis="";
            return view('forex.reports.reportCustmomerSales', compact('values','dpt','user','item','disp','userDis','to','from','sale'));
          }
          elseif( $item == 0 and $sale != 0)
          {
            $values = Transactions::leftJoin('customers','transactions.customer_id', '=','customers.id' )
            ->leftJoin('currencies','transactions.currency_id','=','currencies.id')
            ->leftJoin('accounts','transactions.to_id','=','accounts.id')
            ->orderBy('transactions.id', 'desc')
            ->select('*','transactions.id as TId')
            ->where('t_type','sale')
            ->whereBetween('transactions.date_added', [$from, $to])  
            ->where('sale_type',$sale)
            ->get();       
            $dpt = "All";
            $user = "All";
            $item ="All";
            $disp="";
            $userDis="";
            return view('forex.reports.reportCustmomerSales', compact('values','dpt','user','item','disp','userDis','to','from','sale'));
          }
          elseif( $item != 0 and $sale == 0)
          {
            $values = Transactions::leftJoin('customers','transactions.customer_id', '=','customers.id' )
            ->leftJoin('currencies','transactions.currency_id','=','currencies.id')
            ->leftJoin('accounts','transactions.to_id','=','accounts.id')
            ->orderBy('transactions.id', 'desc')
            ->select('*','transactions.id as TId')
            ->where('t_type','sale')
            ->whereBetween('transactions.date_added', [$from, $to])  
            ->where('transactions.customer_id',$item)
            ->get();

            $dpt = "All";
            $user = "All";
            $act = customer::where('id',$item)->first();
            $item =$act->cust_name;          
            $sale = "All";
            $disp="d-none";
            $userDis="";
            return view('forex.reports.reportCustmomerSales', compact('values','dpt','user','item','disp','userDis','to','from','sale'));
          }
          elseif( $item != 0 and $sale != 0)
          {
            $values = Transactions::leftJoin('customers','transactions.customer_id', '=','customers.id' )
            ->leftJoin('currencies','transactions.currency_id','=','currencies.id')
            ->leftJoin('accounts','transactions.to_id','=','accounts.id')
            ->orderBy('transactions.id', 'desc')
            ->select('*','transactions.id as TId')
            ->where('t_type','sale')
            ->whereBetween('transactions.date_added', [$from, $to])  
            ->where('transactions.customer_id',$item)
            ->where('sale_type',$sale)
            ->get();
            $dpt = "All";
            $user = "All"; 
            $act = customer::where('id',$item)->first();
            $item =$act->cust_name; 
            $disp="d-none";
            $userDis="";
            return view('forex.reports.reportCustmomerSales', compact('values','dpt','user','item','disp','userDis','to','from','sale'));
          }
          DB::statement("SET sql_mode=(SELECT CONCAT(@@sql_mode, ',ONLY_FULL_GROUP_BY'));");
    }

    public function Supplierpurchases(Request $request)
    {
        DB::statement("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));");
        $this->validate($request,[
            'supplier'=>'required',
            'type'=>'required'
        ]);

        $item = $request->input('supplier');
        $to = $request->input('to');
        $from = $request->input('from');
        $sale = $request->input('type');
          if ( $item == 0 and $sale == 0)
          {
            $values= Transactions::where('t_type','purchase')
            ->leftJoin('accounts','transactions.to_id','=','accounts.id')
            ->leftJoin('suppliers','transactions.supplier_id', '=','suppliers.id' )
            ->leftJoin('currencies','transactions.currency_id','=','currencies.id')
            ->whereBetween('transactions.date_added', [$from, $to])            
            ->get();
            $dpt = "All";
            $user = "All";
            $item ="All";
            $sale ="All";
            $disp="";
            $userDis="";
            return view('forex.reports.reportSupplierPurchases', compact('values','dpt','user','item','disp','userDis','to','from','sale'));
          }
          elseif( $item == 0 and $sale != 0)
          {
            $values= Transactions::where('t_type','purchase')
            ->leftJoin('accounts','transactions.to_id','=','accounts.id')
            ->leftJoin('suppliers','transactions.supplier_id', '=','suppliers.id' )
            ->leftJoin('currencies','transactions.currency_id','=','currencies.id')
            ->whereBetween('transactions.date_added', [$from, $to])  
            ->where('sale_type',$sale)
            ->get();       
            $dpt = "All";
            $user = "All";
            $item ="All";
            $disp="";
            $userDis="";
            return view('forex.reports.reportSupplierPurchases', compact('values','dpt','user','item','disp','userDis','to','from','sale'));
          }
          elseif( $item != 0 and $sale == 0)
          {
            $values= Transactions::where('t_type','purchase')
            ->leftJoin('accounts','transactions.to_id','=','accounts.id')
            ->leftJoin('suppliers','transactions.supplier_id', '=','suppliers.id' )
            ->leftJoin('currencies','transactions.currency_id','=','currencies.id')
            ->whereBetween('transactions.date_added', [$from, $to])  
            ->where('transactions.supplier_id',$item)
            ->get();

            $dpt = "All";
            $user = "All";
            $act = supplier::where('id',$item)->first();
            $item =$act->sup_name;           
            $sale = "All";
            $disp="d-none";
            $userDis="";
            return view('forex.reports.reportSupplierPurchases', compact('values','dpt','user','item','disp','userDis','to','from','sale'));
          }
          elseif( $item != 0 and $sale != 0)
          {
            $values= Transactions::where('t_type','purchase')
            ->leftJoin('accounts','transactions.to_id','=','accounts.id')
            ->leftJoin('suppliers','transactions.supplier_id', '=','suppliers.id' )
            ->leftJoin('currencies','transactions.currency_id','=','currencies.id')
            ->whereBetween('transactions.date_added', [$from, $to])  
            ->where('transactions.supplier_id',$item)
            ->where('sale_type',$sale)
            ->get();
            $dpt = "All";
            $user = "All";
            $act = supplier::where('id',$item)->first();
            $item =$act->sup_name;
            $disp="d-none";
            $userDis="";
            return view('forex.reports.reportSupplierPurchases', compact('values','dpt','user','item','disp','userDis','to','from','sale'));
          }
          DB::statement("SET sql_mode=(SELECT CONCAT(@@sql_mode, ',ONLY_FULL_GROUP_BY'));");
    }
    

}
