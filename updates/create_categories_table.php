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
            $table->string('slug')->index();
            $table->string('code')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('rablab_showcase_items_categories', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('item_id')->unsigned();
            $table->integer('category_id')->unsigned();
            $table->primary(['item_id', 'category_id']);
        });
    }

    public function down()
    {
        Schema::drop('rablab_showcase_categories');
        Schema::drop('rablab_showcase_items_categories');
    }

}
