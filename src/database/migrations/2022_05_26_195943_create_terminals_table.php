<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTerminalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('terminals', function (Blueprint $table) {
            $table->id();
            $table->string('serial',150)->nullable();
            $table->string('password',300)->nullable();
            $table->boolean('vuelto')->nullable();
            $table->boolean('reversoc2p')->nullable();
            $table->string('status',30)->nullable();
            $table->unsignedBigInteger('mark_id')->unsigned();
            $table->foreign('mark_id')->references('id')->on('det_lists');
            $table->unsignedBigInteger('model_id')->unsigned();
            $table->foreign('model_id')->references('id')->on('det_lists');
            $table->unsignedBigInteger('branch_id')->unsigned();
            $table->foreign('branch_id')->references('id')->on('branches');
            $table->unsignedBigInteger('affiliate_id')->unsigned();
            $table->foreign('affiliate_id')->references('id')->on('affiliates');
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
        Schema::dropIfExists('terminals');
    }
}
