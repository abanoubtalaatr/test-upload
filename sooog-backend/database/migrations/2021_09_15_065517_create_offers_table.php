<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['percentage', 'value', 'free_product'])->default('percentage');
            $table->decimal('value', 13, 3)->nullable();
            $table->foreignId('free_product_id')->nullable()->constrained('products')->onDelete('cascade');
            $table->foreignId('store_id')->nullable()->constrained('stores')->onDelete('cascade');
            $table->date('start_date');
            $table->date('end_date');
            $table->boolean('is_active')->default(1);
            $table->foreignId('created_by')->nullable()->constrained('admins')->onDelete('cascade');
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
        Schema::dropIfExists('offers');
    }
}
