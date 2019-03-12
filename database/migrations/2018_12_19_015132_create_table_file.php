<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableFile extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file', function (Blueprint $table) {
            $table->increments('ID');
            $table->enum('ClassName', array('File','Folder','Image','Image_Cached'))->nullable()->default('File');
            $table->dateTime('LastEdited')->nullable();
            $table->dateTime('Created')->nullable();
            $table->string('Name', 255)->nullable();
            $table->string('Title', 255)->nullable();
            $table->mediumText('Filename')->nullable();
            $table->mediumText('Content')->nullable();
            $table->tinyInteger('ShowInSearch')->default(1);
            $table->integer('ParentID')->default(0);
            $table->integer('OwnerID')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('file');
    }
}
