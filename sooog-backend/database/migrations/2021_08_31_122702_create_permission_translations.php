<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissionTranslations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permission_translations', function (Blueprint $table) {
            $table->id();
            $table->string('display_name');
            $table->string('key_name')->nullable();
            $table->string('locale')->index();
            $table->foreignId('permission_id')->constrained('permissions')->onDelete('cascade');
            $table->unique(['permission_id','locale']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permission_translations');
    }
}
