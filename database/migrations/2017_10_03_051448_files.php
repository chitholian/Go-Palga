<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Files extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
        	$table->increments('id');
	        $table->unsignedInteger('folder_id');
	        $table->integer('index');
	        $table->integer('size')->nullable();
	        $table->integer('downloads')->default(0);
	        $table->string('extension')->nullable();
	        $table->string('type')->nullable();
	        $table->string('title');
	        $table->string('path')->nullable();
	        $table->string('slug')->unique();
	        $table->string('tags')->nullable();
	        $table->text('description')->nullable();
	        $table->unsignedInteger('thumb_id')->default(1);
	        $table->timestamps();
	        $table->foreign('folder_id')->references('id')->on('folders');
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
        Schema::dropIfExists('files');
    }
}
