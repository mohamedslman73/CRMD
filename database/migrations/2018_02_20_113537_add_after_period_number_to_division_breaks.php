<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAfterPeriodNumberToDivisionBreaks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
            Schema::table('division_breaks', function (Blueprint $table) {
                $table->integer('after_period_number')->nullable();
            });
        }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('division_breaks', function (Blueprint $table) {
            //
        });
    }
}
