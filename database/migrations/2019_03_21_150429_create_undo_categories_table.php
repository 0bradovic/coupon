<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUndoCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('undo_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug')->index();
            $table->string('sku')->nullable()->unique();
            $table->string('img_src')->nullable();
            $table->integer('parent_id')->nullable();
            $table->integer('position');
            $table->boolean('display')->default(1);
            $table->integer('category_id')->unsigned()->index()->nullable();
            $table->enum('type', ['add', 'edit', 'delete'])->nullable();
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
        Schema::dropIfExists('undo_categories');
    }
}
