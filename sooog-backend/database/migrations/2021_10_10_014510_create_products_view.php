<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::statement("DROP VIEW IF EXISTS `products_view`");
        \DB::statement("
            CREATE VIEW products_view AS
            SELECT 
                products.*, settings.body AS added_tax,
                (products.price * (1+(settings.body / 100))) As price_including_tax
                FROM products
                LEFT OUTER JOIN settings ON settings.key = 'added_tax'
        ");
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::statement("DROP VIEW IF EXISTS `products_view`");
    }
}