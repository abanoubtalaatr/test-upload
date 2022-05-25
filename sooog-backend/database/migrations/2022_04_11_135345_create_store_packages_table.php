<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStorePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_packages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->constrained('stores')->onDelete('cascade');
            $table->foreignId('package_id')->constrained('packages')->onDelete('cascade');
            $table->integer('days');
            $table->date('from');
            $table->date('expire_at');
            $table->decimal('price', 13, 3)->default(0.000);
            $table->integer('product_number');
            $table->integer('order_number');
            $table->boolean('has_chat')->default(0);
            $table->boolean('is_rfq')->default(0);
            $table->boolean('is_free')->default(0);
            $table->boolean('is_active')->default(1);
            $table->boolean('is_paid')->default(0);
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
        Schema::dropIfExists('store_packages');
    }
}
