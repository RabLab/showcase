<?php namespace RabLab\Showcase\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateCategoriesTable extends Migration
{

    public function up()
    {
        Schema::create('rablab_showcase_categories', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->string('slug', 100)->index();
            $table->string('code')->nullable();
            $table->text('description')->nullable();
            $table->interger('sort');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('rablab_showcase_categories');
    }

}
