<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Folders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('folders', function (Blueprint $table) {
	        $table->increments('id');
	        $table->unsignedInteger('category_id');
	        $table->integer('index');
	        $table->string('title');
	        $table->string('slug')->unique();
	        $table->string('tags')->nullable();
	        $table->text('description')->nullable();
	        $table->unsignedInteger('icon_id')->default(1);
	        $table->foreign('category_id')->references('id')->on('categories');
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
        Schema::dropIfExists('folders');
    }
}
