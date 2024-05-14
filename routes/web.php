<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/management/dashboard',[RegisteredUserController::class, 'index'])->middleware(['auth','role:superadministrator'])->name('manage.index');
Route::resource('users',RegisteredUserController::class)->middleware(['auth','role:superadministrator|administrator|user']); 
Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->middleware(['auth','role:superadministrator|administrator|user'])->name('dashboard');
Route::group(['namespace' => 'forex','middleware' => ['auth','role:superadministrator|administrator|user'], 'prefix' => 'forex' ], function() {

    Route::get('/user/delete/{id}', [RegisteredUserController::class, 'deleteUser'])->middleware(['auth','role:superadministrator|administrator|user'])->name('removeUser');
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index']);
    Route::get('/reset', [App\Http\Controllers\DashboardController::class, 'reset']);

    //------------------------------------currency routes-------------------------------------------------
    Route::get('/currencies', [App\Http\Controllers\CurrencyController::class, 'index']);
    Route::post('/currencies/add', [App\Http\Controllers\CurrencyController::class, 'store']);
    Route::get('/currencies/delete/{id}', [App\Http\Controllers\CurrencyController::class, 'destroy']);
    Route::post('/currencies/update/{id}', [App\Http\Controllers\CurrencyController::class, 'update']);


    //------------------------------------account routes-------------------------------------------------
    Route::get('/accounts', [App\Http\Controllers\AccountController::class, 'index']);
    Route::get('/accounts/balances', [App\Http\Controllers\AccountController::class, 'index2']);
    Route::post('/accounts/add', [App\Http\Controllers\AccountController::class, 'store']);
    Route::get('/accounts/delete/{id}', [App\Http\Controllers\AccountController::class, 'destroy']);
    Route::post('accounts/update/{id}', [App\Http\Controllers\AccountController::class, 'update']);

    //----------------------------transfer routes------------------------------------------------
    Route::get('accounts/transfers', [App\Http\Controllers\TransferController::class, 'index']);
    Route::get('transfer/new/{id}', [App\Http\Controllers\TransferController::class, 'create']);
    Route::get('transfer/getAcct1', [App\Http\Controllers\TransferController::class, 'getAcct1']);
    Route::get('transfer/getAcct2', [App\Http\Controllers\TransferController::class, 'getAcct2']);
    Route::post('/transfer/add', [App\Http\Controllers\TransferController::class, 'store']);

     //----------------------------Expenditures routes------------------------------------------------
     Route::get('expenditures', [App\Http\Controllers\ExpenditureController::class, 'index']);
     Route::get('expenditures/new/{id}', [App\Http\Controllers\ExpenditureController::class, 'create']);
     Route::post('/expenditures/add', [App\Http\Controllers\ExpenditureController::class, 'store']);

    //----------------------------------supplier routes---------------------------------------------
    Route::get('/suppliers', [App\Http\Controllers\SuppliersController::class, 'index']);
    Route::post('/suppliers/add', [App\Http\Controllers\SuppliersController::class, 'store']);
    Route::get('/supplier/delete/{id}', [App\Http\Controllers\SuppliersController::class, 'destroy']);
    Route::post('/supplier/update/{id}', [App\Http\Controllers\SuppliersController::class, 'update']);

    //----------------------------------customer routes---------------------------------------------
    Route::get('/customers', [App\Http\Controllers\CustomersController::class, 'index']);
    Route::post('/customers/add', [App\Http\Controllers\CustomersController::class, 'store']);
    Route::get('/customers/delete/{id}', [App\Http\Controllers\CustomersController::class, 'destroy']);
    Route::post('/customers/update/{id}', [App\Http\Controllers\CustomersController::class, 'update']);
    Route::get('/customers/show/{id}', [App\Http\Controllers\CustomersController::class, 'show'])->name('viewcust');
    Route::get('/customers/transactions/{id}', [App\Http\Controllers\CustomersController::class, 'show2'])->name('viewcust2');
   


     //----------------------------------loss routes---------------------------------------------
     Route::get('/losses', [App\Http\Controllers\LossController::class, 'index']);
     Route::post('/losses/add', [App\Http\Controllers\LossController::class, 'store']);
     Route::get('/losses/delete/{id}', [App\Http\Controllers\LossController::class, 'destroy']);
     Route::post('/losses/update/{id}', [App\Http\Controllers\LossController::class, 'update']);


    //----------------------------------payment routes---------------------------------------------
    Route::get('/payments', [App\Http\Controllers\PayementController::class, 'index']);
    Route::post('/payments/add/m', [App\Http\Controllers\PayementController::class, 'store']);
    Route::post('/payments/add/r', [App\Http\Controllers\PayementController::class, 'store2']);
    Route::get('/payments/delete/{id}', [App\Http\Controllers\PayementController::class, 'destroy']);
    Route::post('/payments/update/{id}', [App\Http\Controllers\PayementController::class, 'update']);
    Route::get('/payments/make', [App\Http\Controllers\PayementController::class, 'make']);
    Route::get('/payments/receive', [App\Http\Controllers\PayementController::class, 'receive']);
    Route::get('payments/getcust', [App\Http\Controllers\PayementController::class, 'getcust']);
    Route::get('payments/getSupp', [App\Http\Controllers\PayementController::class, 'getSupp']);
     Route::post('payments/delete', [App\Http\Controllers\PayementController::class, 'destroyPay']);
    Route::post('suppayments/delete', [App\Http\Controllers\PayementController::class, 'destroyLoan']);


    //----------------------------Sales routes------------------------------------------------
    Route::get('sales', [App\Http\Controllers\TransactionsController::class, 'index']);
    Route::get('/sale/{id}', [App\Http\Controllers\TransactionsController::class, 'create']);
    Route::post('/sale/add', [App\Http\Controllers\TransactionsController::class, 'store']);
    Route::get('/purchase/{id}', [App\Http\Controllers\TransactionsController::class, 'create2']);
    Route::post('/purchase/add', [App\Http\Controllers\TransactionsController::class, 'store2']);
    Route::get('transactions/getAccts', [App\Http\Controllers\TransactionsController::class, 'getAccts']);
    Route::get('transactions', [App\Http\Controllers\TransactionsController::class, 'index']);
    Route::get('transactions/sales', [App\Http\Controllers\TransactionsController::class, 'sales']);
    Route::get('transactions/purchases', [App\Http\Controllers\TransactionsController::class, 'purchases']);

    Route::post('transactions/delete/purchase', [App\Http\Controllers\TransactionsController::class, 'destroypurchase']);
    Route::post('transactions/delete/sale', [App\Http\Controllers\TransactionsController::class, 'destroysale']);

    Route::get('capital', [App\Http\Controllers\CapitalTransactionsController::class, 'index']);
    Route::get('/capital/deposit', [App\Http\Controllers\CapitalTransactionsController::class, 'create']);
    Route::post('/capital/deposit/add', [App\Http\Controllers\CapitalTransactionsController::class, 'store']);
    Route::get('/capital/withdraw', [App\Http\Controllers\CapitalTransactionsController::class, 'create2']);
    Route::post('/capital/withdraw/add', [App\Http\Controllers\CapitalTransactionsController::class, 'store2']);


    Route::get('reports', [App\Http\Controllers\ReportController::class, 'index'])->name('reports');
    Route::post('reports/daily', [App\Http\Controllers\ReportController::class, 'dailysales'])->name('dailysales');
    Route::post('reports/expenses', [App\Http\Controllers\ReportController::class, 'expenses'])->name('reportexpense');
    Route::post('reports/porofitLoss', [App\Http\Controllers\ReportController::class, 'profitLoss'])->name('reportProfitLoss');
    Route::post('reports/purchases', [App\Http\Controllers\ReportController::class, 'purchases'])->name('reportPurchase');
    Route::post('reports/sales', [App\Http\Controllers\ReportController::class, 'sales'])->name('reportSales');
    Route::post('reports/customer', [App\Http\Controllers\ReportController::class, 'Customersales'])->name('reportCustSales');
    Route::post('reports/supplier', [App\Http\Controllers\ReportController::class, 'Supplierpurchases'])->name('reportSuppliers');
    Route::resource('report',App\Http\Controllers\ReportController::class); 
    Route::group(['prefix' => 'admin'], function () {
        //User Management
        require __DIR__.'/user_mgt.php';
    });
});
require __DIR__.'/auth.php';
