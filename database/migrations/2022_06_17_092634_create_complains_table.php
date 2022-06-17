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
        Schema::create('complains', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unsigned();
            $table->string('name');
            $table->string('phone');
            $table->string('nid');
            $table->string('email')->nullable();
            $table->string('organization_name');
            $table->string('product_name');
            $table->string('product_photo');
            $table->string('invoice_photo');
            $table->string('department');
            $table->string('subDepartment');
            $table->string('subject');
            $table->longText('description');
            $table->string('case_no');
            $table->string('result_date')->nullable();
            $table->integer('case_status')->default('0')->comment('0 = pending, 1 = compleated');
            $table->string('apply_date');
            $table->string('hearing_date')->nullable();
            $table->string('district_id');
            $table->string('division_id');
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
        Schema::dropIfExists('complains');
    }
};
