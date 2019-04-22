<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUndosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('undos', function (Blueprint $table) {
            $table->increments('id');
            $table->text('properties');
            $table->enum('type',['Deleted','Edited']);
            $table->integer('user_id')->unsigned()->index()->nullable();
            $table->integer('role_id')->unsigned()->index()->nullable();
            $table->integer('slider_id')->unsigned()->index()->nullable();
            $table->integer('offer_type_id')->unsigned()->index()->nullable();
            $table->integer('offer_id')->unsigned()->index()->nullable();
            $table->integer('category_id')->unsigned()->index()->nullable();
            $table->integer('custom_page_id')->unsigned()->index()->nullable();
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
        Schema::dropIfExists('undos');
    }
}
