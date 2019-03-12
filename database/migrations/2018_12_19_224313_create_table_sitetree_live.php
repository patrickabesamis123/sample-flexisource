<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSitetreeLive extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sitetree_live', function (Blueprint $table) {
            $table->increments('ID');
            $table->enum('ClassName', array('SiteTree','Page','BlogHolder','BlogPost','Candidate','Company','Employer','FileUploads','Homepage','ImageHelper','Job','Login','Me','PmvLinkHelper','ProfilePublic','Refresher','Register','StaticPages','ErrorPage','RedirectorPage','VirtualPage'))->nullable()->default('SiteTree');
            $table->dateTime('LastEdited')->nullable();
            $table->dateTime('Created')->nullable();
            $table->string('URLSegment', 255)->nullable();
            $table->string('Title', 255)->nullable();
            $table->string('MenuTitle', 100)->nullable();
            $table->mediumText('Content')->nullable();
            $table->mediumText('MetaDescription')->nullable();
            $table->mediumText('ExtraMeta')->nullable();
            $table->unsignedTinyInteger('ShowInMenus')->default(0);
            $table->unsignedTinyInteger('ShowInSearch')->default(0);
            $table->integer('Sort')->default(0);
            $table->unsignedTinyInteger('HasBrokenFile')->default(0);
            $table->unsignedTinyInteger('HasBrokenLink')->default(0);
            $table->string('ReportClass', 50)->nullable();
            $table->enum('CanViewType', array('Anyone','LoggedInUsers','OnlyTheseUsers','Inherit'))->nullable()->default('Inherit');
            $table->enum('CanEditType', array('Anyone','LoggedInUsers','OnlyTheseUsers','Inherit'))->nullable()->default('Inherit');
            $table->integer('Version')->default(0);
            $table->integer('ParentID')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sitetree_live');
    }
}
