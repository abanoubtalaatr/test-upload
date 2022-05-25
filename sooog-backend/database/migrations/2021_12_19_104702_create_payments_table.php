<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->decimal('total', 13, 3)->default(0.000);
            $table->decimal('application_dues_percentage', 12, 2)->default(0);
            $table->decimal('application_dues', 13, 3)->default(0.000);
            $table->decimal('amount', 13, 3)->default(0);
            $table->string('receipt')->nullable();
            $table->foreignId('store_id')->nullable()->constrained('stores')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
