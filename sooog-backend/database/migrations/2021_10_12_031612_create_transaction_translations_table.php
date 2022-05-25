<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_translations', function (Blueprint $table) {
            $table->id();
            $table->text('reason');
            $table->string('locale')->index();
            $table->foreignId('transaction_id')->constrained('transactions')->onDelete('cascade');
            $table->unique(['transaction_id','locale']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaction_translations');
    }
}
