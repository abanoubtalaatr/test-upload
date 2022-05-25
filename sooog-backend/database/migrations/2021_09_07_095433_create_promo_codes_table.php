<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromoCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promo_codes', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('type', ['percentage', 'value', 'free_delivery_charge', 'free_cash_charge'])->default('percentage');
            $table->decimal('value', 13, 3)->default(0);
            $table->unsignedBigInteger('max_use_number');
            $table->enum('applied_to', ['all_users', 'specific_user']);
            $table->decimal('order_min_cost', 13, 3)->default(0);
            $table->boolean('is_active')->default(1);
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
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
        Schema::dropIfExists('promo_codes');
    }
}
