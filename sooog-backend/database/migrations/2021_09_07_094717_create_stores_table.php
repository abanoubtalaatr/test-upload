<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('image')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('username')->nullable();
            $table->string('address')->nullable();
            $table->integer('city_id')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('iban_no')->nullable();
            $table->string('swift_code')->nullable();
            $table->string('bank_account_no')->nullable();
            $table->string('commercial_registry_no')->nullable();
            $table->string('commercial_registry_photo')->nullable();
            $table->boolean('status')->default(0); // 0:new request, 1:accepted, 2:rejected
            $table->boolean('is_active')->default(1);
            $table->text('deactivation_reason')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->enum('type', ['stores', 'centers'])->default('stores');
            $table->boolean('is_featured')->default(0);
            $table->boolean('has_delivery_service')->default(0);
            $table->decimal('delivery_charge', 13, 3)->default(0);
            $table->decimal('application_dues', 12, 2)->default(0);
            $table->softDeletes();
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
        Schema::dropIfExists('stores');
    }
}
