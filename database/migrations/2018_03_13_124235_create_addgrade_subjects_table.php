<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddgradeSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('addgrade_subjects')) {
            Schema::create('addgrade_subjects', function (Blueprint $table) {

                $table->increments('id');
                $table->integer('subject_id')->unsigned();
                $table->integer('addgrade_id')->unsigned();
                $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
                $table->foreign('addgrade_id')->references('id')->on('addgrades')->onDelete('cascade');
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
        Schema::table('addgrade_subjects', function (Blueprint $table) {
            //
        });
    }
}
