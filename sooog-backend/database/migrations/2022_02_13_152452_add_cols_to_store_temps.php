<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColsToStoreTemps extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('store_temps', function (Blueprint $table) {

            $table->string('bank_user_name')->nullable();
            $table->string('bank_country_id')->nullable();
            $table->enum('bank_type',['local','global'])->nullable()->default('local');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('store_temps', function (Blueprint $table) {
            //
        });
    }
}
