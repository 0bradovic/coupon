<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUndoOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('undo_offers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('slug')->index()->nullable();
            $table->string('sku')->unique()->nullable();
            $table->integer('brand_id')->unsigned()->index()->nullable();
            $table->string('highlight')->nullable();
            $table->string('summary')->nullable();
            $table->text('detail')->nullable();
            $table->string('link')->nullable();
            $table->datetime('startDate')->nullable();
            $table->datetime('endDate')->nullable();
            $table->boolean('endDateNull')->nullable();
            $table->string('img_src')->nullable();
            $table->integer('offer_type_id')->unsigned()->index()->nullable();
            $table->integer('user_id')->unsigned()->index()->nullable();
            $table->integer('position')->nullable();
            $table->integer('offer_id')->unsigned()->index()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('undo_offers');
    }
}
