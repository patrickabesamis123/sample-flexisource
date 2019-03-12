<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableBlogpostLive extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blogpost_live', function (Blueprint $table) {
            $table->increments('ID');
            $table->integer('Featured');
            $table->mediumText('Teaser')->nullable();
            $table->date('PostDate')->nullable();
            $table->mediumText('Author')->nullable();
            $table->integer('FeaturedImageID');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blogpost_live');
    }
}
