<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpendituresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenditures', function (Blueprint $table) {
            $table->id();
            $table->string('reff_number')->nullable()->unique();
            $table->string('from_acct')->nullable()->default('Petty cash');
            $table->string('description')->nullable();
            $table->float('exp_amount')->nullable()->default(0);
            $table->string('type')->nullable()->default('Inter account');
            $table->date('date_added')->nullable();
            $table->string('exp_year')->nullable();
            $table->string('exp_month')->nullable();
            $table->string('exp_week')->nullable();
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
        Schema::dropIfExists('expenditures');
    }
}
