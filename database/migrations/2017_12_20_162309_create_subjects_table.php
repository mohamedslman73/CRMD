<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('subjects')) {
            Schema::create('subjects', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('grade_id')->unsigned();
                $table->string('subject_name');
                $table->text('subject_description');
                $table->double('subject_weight');
                $table->double('success_percentage');
                $table->double('attendance_percentage');
                $table->integer('term');
                $table->string('book_name');
                $table->foreign('grade_id')->references('id')->on('grades')->onDelete('cascade');


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
        Schema::dropIfExists('subjects');
    }
}
