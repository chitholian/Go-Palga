<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Mirrors extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mirrors', function (Blueprint $table) {
	        $table->increments('id');
	        $table->unsignedInteger('file_id');
	        $table->string('title');
	        $table->string('url');
	        $table->unsignedInteger('icon_id');
	        $table->foreign('file_id')->references('id')->on('files')->onDelete('cascade');
	        $table->foreign('icon_id')->references('id')->on('icons');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mirrors');
    }
}
