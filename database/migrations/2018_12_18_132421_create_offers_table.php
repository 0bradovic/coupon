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
            $table->string('slug')->index();
            $table->string('sku')->unique()->nullable();
            $table->integer('brand_id')->unsigned()->index()->nullable();
            $table->string('highlight')->nullable();
            $table->string('summary')->nullable();
            $table->text('detail')->nullable();
            $table->string('link');
            $table->datetime('startDate');
            $table->datetime('endDate')->nullable();
            $table->boolean('endDateNull');
            $table->string('img_src')->nullable();
            $table->integer('offer_type_id')->unsigned()->index()->nullable();
            $table->integer('user_id')->unsigned()->index();
            $table->integer('position')->nullable();
            $table->boolean('display')->default(1);
            $table->integer('click')->default(0);
            $table->integer('fp_position')->nullable();
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
