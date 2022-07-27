<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->string('name',150)->nullable();
            $table->string('location',300)->nullable();
            $table->string('phone',10)->nullable();
            $table->enum('branch_type', ['P', 'S'])->nullable(); // P => Principal / S => Secundaria
            $table->unsignedBigInteger('commerce_id')->unsigned();
            $table->foreign('commerce_id')->references('id')->on('commerces');
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
        Schema::dropIfExists('branches');
    }
}
