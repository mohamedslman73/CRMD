<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchoolPhoneNumbersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('school_phone_numbers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->integer('number');

            $table->integer('school_id')->unsigned();
            $table->foreign('school_id')->references('id')->on('schools')
                ->onDelete('cascade');

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
        Schema::dropIfExists('school_phone_numbers');
    }
}
