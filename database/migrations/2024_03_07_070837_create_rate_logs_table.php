<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRateLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rate_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('currency_id')->nullable()->constrained()->onUpdate('restrict')->onDelete('restrict');
            $table->float('buying_rate')->nullable()->default(0);
            $table->float('old_buying_rate')->nullable()->default(0);
            $table->float('selling_rate')->nullable()->default(0);
            $table->float('old_selling_rate')->nullable()->default(0);
            $table->timestamps();
        });

        Schema::table('accounts', function (Blueprint $table) {
            $table->float('foreign_amount',16,2)->nullable()->default(0)->after('available_balance');
        });
        Schema::table('transfers', function (Blueprint $table) {
            $table->float('foreign_amount',16,2)->nullable()->default(0)->after('total_amount');
            $table->float('rate')->nullable()->default(0)->after('foreign_amount');
        });

        Schema::table('capital_transactions', function (Blueprint $table) {
            $table->float('rate')->nullable()->default(0)->after('foreign_amount');
        });
        Schema::table('currencies', function (Blueprint $table) {
            $table->integer('is_default')->nullable()->default(0)->after('is_active');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rate_logs');
    }
}
