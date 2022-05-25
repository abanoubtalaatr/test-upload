<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRefundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('refunds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->foreignId('status_id')->constrained('statuses')->onDelete('cascade');
            $table->foreignId('refund_reason_id')->constrained('refund_reasons')->onDelete('cascade');
            $table->enum('refund_type', ['order', 'items'])->default('items');
            $table->decimal('subtotal', 13, 3);
            $table->decimal('promo_code_discount', 13, 3);
            $table->decimal('total', 13, 3);
            $table->text('note')->nullable();
            $table->text('reason')->nullable();
            $table->foreignId('creatable_id')->nullable();
            $table->string('creatable_type')->nullable();
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
        Schema::dropIfExists('refunds');
    }
}
