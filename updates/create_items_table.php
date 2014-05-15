<?php namespace RabLab\Showcase\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateItemsTable extends Migration
{

    public function up()
    {
        Schema::create('rablab_showcase_items', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('user_id')->unsigned()->index();
            $table->string('title', 100);
            $table->string('slug', 100)->unique()->index();
            $table->char('thumb_id', 15);
            $table->interger('category_id')->nullable();
            $table->text('description')->nullable();
            $table->string('metadata', 250)->nullable();
            $table->text('keywords')->nullable();
            $table->boolean('enable_comments')->default(false);
            $table->boolean('published')->default(false);            
            $table->timestamp('published_at')->nullable();            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('rablab_showcase_items');
    }

}
