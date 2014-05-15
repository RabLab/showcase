<?php namespace RabLab\Showcase\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateImagesTable extends Migration
{

    public function up()
    {
        Schema::table('rablab_showcase_images', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name', 100);
            $table->string('filename', 100)->index();
            $table->string('label')->nullable();
            $table->interger('sort');
            $table->timestamp('published_at')->nullable();   
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('rablab_showcase_images');
    }
}
