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
            $table->string('booking_id');
            $table->enum('payment_method', ['cash', 'card'])->default('card');
            $table->float('total_amount', 8, 2);
            //$table->text('submitted_data');
            $table->text('payment_data');
            $table->text('validation_data');
            $table->dateTime('validation_date');
            $table->enum('payment_status', ['pending', 'cancelled', 'failed', 'success', 'unknown'])->default('pending');
           // $table->enum('validation_status', ['valid', 'validated', 'invalid_transaction', 'pending'])->default('pending');
            //$table->dateTime('edit_date');
            $table->string('edited_by', 25)->nullable(); // manually validate a transaction
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
