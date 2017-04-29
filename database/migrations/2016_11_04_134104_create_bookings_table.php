<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->integer('schedule_id');
            //$table->integer('user_id');
            $table->string('user_id', 25);
            // $table->string('name');
            // $table->smallInteger('mobile_no');
            // $table->string('email');
            $table->tinyInteger('seats');
            $table->float('amount', 8, 2); 
            $table->date('date');
            $table->string('pickup_point');
            $table->string('dropping_point');
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
        Schema::dropIfExists('bookings');
    }
}
