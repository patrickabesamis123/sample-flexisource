<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTimestampsCandidateJobWatchlistTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('c_job_watchlist', function (Blueprint $table) {
            $table->renameColumn('recorded_date', 'created_at');
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('c_job_watchlist', function (Blueprint $table) {
            $table->renameColumn('created_at', 'recorded_date');
            $table->dropColumn('updated_at');
        });
    }
}
