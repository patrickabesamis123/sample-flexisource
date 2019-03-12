<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyETeamsMembers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('e_teams_members', function (Blueprint $table) {
            $table->dropForeign('FK_35EE5F2D296CD8AE');
            $table->foreign('team_id')->references('id')->on('e_teams')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('e_teams_members', function (Blueprint $table) {
            //
        });
    }
}
