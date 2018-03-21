<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PjStringerMapping extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create table for storing roles
        Schema::create('pj_stringer_mapping', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pj_id')->unsigned();
            $table->integer('stringer_id')->unsigned();
            
            $table->foreign('pj_id')->references('id')->on('users_admin')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('stringer_id')->references('id')->on('users_admin')
                ->onUpdate('cascade')->onDelete('cascade');
                            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pj_stringer_mapping');
    }
}
