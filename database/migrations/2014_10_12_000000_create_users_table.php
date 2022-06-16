<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
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
            $table->string('name')->length(100);
            $table->integer('phone')->unique();
            $table->string('nid')->unique();
            $table->string('email')->length(100)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->integer('gender')->nullable()->comment('0 = male, 1 = female');
            $table->string('birth_date')->length(100)->nullable();
            $table->string('father_name')->length(100)->nullable();
            $table->string('mother_name')->length(100)->nullable();
            $table->string('present_address')->length(200)->nullable();
            $table->string('permanent_address')->length(200)->nullable();
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
};
