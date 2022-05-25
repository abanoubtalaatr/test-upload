<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('country_code', 50)->nullable();
            $table->string('phone');
            $table->timestamp('phone_verified_at')->nullable();
            $table->string('password');
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->string('avatar')->nullable();
            $table->boolean('is_active')->default(0);
            $table->bigInteger('login_numbers')->default(0);
            $table->timestamp('last_login_at')->nullable();
            $table->string('verification_code',50)->nullable();
            $table->string('updated_phone')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
