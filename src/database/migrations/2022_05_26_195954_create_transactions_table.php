<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('bank',150)->nullable();
            $table->string('client_phone',9)->nullable();
            $table->string('client_affiliate',9)->nullable();
            $table->string('amount',10)->nullable();
            $table->date('date')->nullable();
            $table->time('hour')->nullable();
            $table->string('reference',300)->nullable();
            $table->string('reason',150)->nullable();
            $table->unsignedBigInteger('terminal_id')->unsigned();
            $table->foreign('terminal_id')->references('id')->on('terminals');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
