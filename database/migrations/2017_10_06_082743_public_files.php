<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PublicFiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('public_files', function (Blueprint $table) {
	        $table->increments('id');
	        $table->string('title');
	        $table->string('type');
	        $table->integer('size');
	        $table->string('path');
	        $table->unsignedInteger('thumb_id')->default(1);
	        $table->timestamps();
	        $table->foreign('thumb_id')->references('id')->on('thumbs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('public_files');
    }
}
