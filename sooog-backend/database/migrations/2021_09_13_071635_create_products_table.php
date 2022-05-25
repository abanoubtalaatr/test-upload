<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('quantity')->nullable();
            $table->decimal('price', 13, 3)->nullable();
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->foreignId('brand_id')->nullable()->constrained('brands')->onDelete('cascade');
            $table->foreignId('store_id')->constrained('stores')->onDelete('cascade');
            $table->string('image')->nullable();
            $table->string('barcode')->nullable();
            $table->foreignId('made_in')->nullable()->constrained('countries')->onDelete('cascade');
            $table->decimal('preview_fees', 13, 3)->nullable();
            $table->unsignedBigInteger('max_purchase_quantity')->default(0);
            $table->boolean('is_active')->default(1);
            $table->date('deactivation_start_date')->nullable();
            $table->date('deactivation_end_date')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('admins');
            //$table->softDeletes();

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
        Schema::dropIfExists('products');
    }
}
