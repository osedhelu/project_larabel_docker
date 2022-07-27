<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('det_lists', function (Blueprint $table) {
            $table->id();
            $table->string('name',150)->nullable();
            $table->unsignedBigInteger('list_id')->unsigned();
            $table->foreign('list_id')->references('id')->on('lists');
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
        Schema::dropIfExists('det_lists');
    }
}
