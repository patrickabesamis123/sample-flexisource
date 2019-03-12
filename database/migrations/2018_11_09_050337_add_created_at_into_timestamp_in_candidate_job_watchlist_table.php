<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCreatedAtIntoTimestampInCandidateJobWatchlistTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       /**
        * needed to run raw db statement had an issue with doctrine
        * when changing data type into `timestamp`
        * https://github.com/doctrine/dbal/issues/2558
        */
        DB::statement('SET SQL_MODE="ALLOW_INVALID_DATES"');
        DB::statement('ALTER TABLE c_job_watchlist
                      MODIFY created_at TIMESTAMP;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET SQL_MODE="ALLOW_INVALID_DATES"');
        DB::statement('ALTER TABLE c_job_watchlist
                       MODIFY created_at DATETIME;');
    }
}
