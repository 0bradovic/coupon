<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSlidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sliders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('img_src');
            $table->string('up_text')->nullable();
            $table->string('up_text_color')->nullable();
            $table->string('down_text')->nullable();
            $table->string('down_text_color')->nullable();
            $table->string('center_text')->nullable();
            $table->string('center_text_color')->nullable();
            $table->string('left_text')->nullable();
            $table->string('left_text_color')->nullable();
            $table->string('right_text')->nullable();
            $table->string('right_text_color')->nullable();
            $table->string('link')->nullable();
            $table->integer('position');
            $table->boolean('active');
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
        Schema::dropIfExists('sliders');
    }
}
