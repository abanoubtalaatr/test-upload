<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->decimal('price', 13, 3)->default(0.000);
            $table->integer('months')->default(1);
            $table->string('image')->nullable();
            $table->integer('product_number');
            $table->integer('order_number');
            $table->boolean('has_chat')->default(0);
            $table->boolean('is_rfq')->default(0);
            $table->boolean('is_free')->default(0);
            $table->boolean('is_active')->default(1);
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
        Schema::dropIfExists('packages');
    }
}
