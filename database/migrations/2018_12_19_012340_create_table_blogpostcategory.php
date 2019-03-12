<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableBlogpostcategory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blogpostcategory', function (Blueprint $table) {
            $table->increments('ID');
            $table->enum('ClassName', array('BlogPostCategory'))->nullable()->default('BlogPostCategory');
            $table->dateTime('LastEdited')->nullable();
            $table->dateTime('Created')->nullable();
            $table->string('Name', 50)->nullable();
            $table->string('Slug', 50)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blogpostcategory');
    }
}
