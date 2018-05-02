<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('questions')) {
            Schema::create('questions', function (Blueprint $table) {
                $table->increments('id');
                $table->text('q_text');
                $table->enum('q_type', ['true_or_false', 'complete','match','multi_choice','essay']);

                $table->integer('material_id')->unsigned();
                $table->foreign('material_id')->references('id')->on('materials')->onDelete('cascade');

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
        Schema::dropIfExists('questions');
    }
}
