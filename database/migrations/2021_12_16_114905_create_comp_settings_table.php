<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comp_settings', function (Blueprint $table) {
            $table->id();
            $table->string('comp_name')->nullable();
            $table->string('default_currency')->nullable();
            $table->string('comp_email')->nullable();
            $table->string('comp_contact')->nullable();
            $table->string('comp_location')->nullable();
            $table->string('comp_tagline')->nullable();
            $table->string('comp_owner')->nullable();
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
        Schema::dropIfExists('comp_settings');
    }
}
