<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyAddCurrencyToKickstarterLots extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kickstarter_lots', function (Blueprint $table) {
            $table->text('currency');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kickstarter_lots', function (Blueprint $table) {
            $table->dropColumn('currency');

        });
    }
}
