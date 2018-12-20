<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('sku')->unique()->nullable();
            $table->integer('brand_id')->unsigned()->index();
            $table->string('highlight');
            $table->string('summary');
            $table->text('detail');
            $table->string('link');
            $table->datetime('start');
            $table->datetime('end');
            $table->integer('offer_type_id')->unsigned()->index();
            $table->integer('user_id')->unsigned()->index();
            $table->integer('position')->unique();
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
        Schema::dropIfExists('offers');
    }
}
