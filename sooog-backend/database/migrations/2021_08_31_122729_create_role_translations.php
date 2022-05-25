<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoleTranslations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role_translations', function (Blueprint $table) {
            $table->id();
            $table->string('display_name');
            $table->string('locale')->index();
            $table->foreignId('role_id')->constrained('roles')->onDelete('cascade');
            $table->unique(['role_id','locale']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('role_translations');
    }
}
