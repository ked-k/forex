<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('reff_number')->nullable()->unique();
            $table->string('from_acct')->nullable();
            $table->integer('from_id')->nullable();
            $table->string('to_acct')->nullable();
            $table->integer('to_id')->nullable();
            $table->foreignId('currency_id')->nullable()->constrained()->onUpdate('restrict')->onDelete('restrict');
            $table->float('rate')->nullable()->default(0);
            $table->float('total_amount')->nullable()->default(0);
            $table->float('foreign_amount')->nullable()->default(0);
            $table->float('charges')->nullable()->default(0);
            $table->string('sale_type')->nullable()->default('Cash');
            $table->foreignId('customer_id')->nullable()->constrained()->onUpdate('restrict')->onDelete('restrict');
            $table->date('date_added')->nullable();
            $table->string('trans_year')->nullable();
            $table->string('trans_month')->nullable();
            $table->string('trans_week')->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->onUpdate('restrict')->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
