<?php namespace RabLab\Showcase\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateItemsContentHtml extends Migration
{

    public function up()
    {
        Schema::table('rablab_showcase_items', function($table)
        {
            $table->text('content_html');
        });
    }

    public function down()
    {
        Schema::table('rablab_showcase_items', function($table)
        {
            $table->dropColumn('content_html');
        });
    }
}
