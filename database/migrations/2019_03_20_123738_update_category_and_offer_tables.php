<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCategoryAndOfferTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('offers', function($table) {
            $table->boolean('display')->default(true)->nullable();
        });

        Schema::table('categories', function($table) {
            $table->boolean('display')->default(true)->nullable();
        });

        Schema::table('undo_offers', function($table) {
            $table->boolean('display')->default(true)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('offers', function($table) {
            $table->dropColumn('display');
        });

        Schema::table('categories', function($table) {
            $table->dropColumn('display');
        });

        Schema::table('undo_offers', function($table) {
            $table->dropColumn('display');
        });

    }
}
