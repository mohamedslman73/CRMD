<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchoolTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('school_types')) {
            Schema::create('school_types', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('school_id')->unsigned();
                $table->integer('type_id')->unsigned();
                $table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');
                $table->foreign('type_id')->references('id')->on('education_types')->onDelete('cascade');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('school_types');
    }
}
