<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('status_id')->constrained('statuses')->onDelete('cascade');
            $table->foreignId('user_address_id')->constrained('user_addresses')->onDelete('cascade');
            $table->foreignId('payment_method_id')->constrained('payment_methods')->onDelete('cascade');
            $table->foreignId('store_id')->constrained('stores')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->date('service_wanted_date')->nullable();
            $table->decimal('subtotal', 13, 3);
            $table->decimal('offer_discount', 13, 3)->default(0.000);
            $table->decimal('delivery_charge', 13, 3)->default(0.000);
            $table->decimal('order_added_tax', 13, 3)->default(0.000);
            $table->decimal('warranties_amount', 13, 3)->default(0.000);
            $table->decimal('promo_code_discount', 13, 3)->default(0.000);
            $table->decimal('wallet_payout', 13, 3)->default(0.000);
            $table->decimal('remain', 13, 3)->default(0.000);
            $table->decimal('total', 13, 3);
            $table->decimal('application_dues', 13, 3)->default(0.000);
            $table->string('promo_code_id')->nullable()->constrained('promo_codes')->onDelete('cascade');
            $table->string('address')->nullable();           
            $table->text('notes')->nullable();
            $table->text('admin_notes')->nullable();
            $table->enum('type', ['stores', 'centers'])->default('stores');
            $table->boolean('is_paid')->default(1);
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
        Schema::dropIfExists('orders');
    }
}
