<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRelatedQueryIdToQueriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('queries', function (Blueprint $table) {
            $table->integer('relatedQuery_id')->nullable()->after('id')->unsigned();
            $table->foreign('relatedQuery_id')->references('id')->on('queries');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('queries', function (Blueprint $table) {
            $table->dropForeign(['relatedQuery_id']);
            $table->dropColumn('relatedQuery_id');
        });
    }
}
