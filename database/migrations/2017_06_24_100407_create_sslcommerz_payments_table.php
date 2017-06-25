<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSslcommerzPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sslcommerz_payments', function (Blueprint $table) {
            $table->increments('id');
            // $table->string('booking_id');
            // $table->float('amount', 8, 2);
            $table->text('submitted_data');
            $table->text('payment_data');
            $table->text('validation_data');
            $table->dateTime('validation_date');
            $table->enum('payment_status', ['pending', 'cancelled', 'failed', 'success', 'unknown'])->default('pending');
            //$table->dateTime('edit_date');
            $table->string('edited_by', 25)->nullable();
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
        Schema::dropIfExists('sslcommerz_payments');
    }
}
