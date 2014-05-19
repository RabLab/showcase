<?php namespace RabLab\Showcase\Updates;

use RabLab\Showcase\Models\Category;
use October\Rain\Database\Updates\Seeder;

class SeedAllTables extends Seeder
{

    public function run()
    {
        //
        // @todo
        //
        // Add a Welcome item or something
        //

        Category::create([
            'name' => 'Uncategorized'
        ]);
    }

}
