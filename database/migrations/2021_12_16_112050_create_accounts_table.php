<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->string('account_name')->nullable()->unique();
            $table->string('account_number')->nullable();
            $table->string('default_currency')->nullable();
            $table->float('account_type')->nullable()->default(0);
            $table->float('cleared_balance')->nullable()->default(0);
            $table->float('available_balance')->nullable()->default(0);
            $table->foreignId('user_id')->nullable()->constrained()->onUpdate('restrict')->onDelete('restrict');
            $table->integer('is_active')->default('1');
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
        Schema::dropIfExists('accounts');
    }
}
