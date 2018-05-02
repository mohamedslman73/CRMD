<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStudentIdToBehaviorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

        public function up()
        {
            if (!Schema::hasTable('behaviors')) {
                Schema::table('behaviors', function (Blueprint $table) {
                    $table->integer('student_id')->unsigned();
                    $table->foreign('student_id')->references('id')->on('users')->onDelete('cascade');
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
        //
    }
}
