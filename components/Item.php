<?php namespace RabLab\Showcase\Components;

use Cms\Classes\ComponentBase;
use RabLab\Showcase\Models\Item as ShowcaseItem;

class Item extends ComponentBase
{
    public $item;

    public function componentDetails()
    {
        return [
            'name'        => 'Showcase Item',
            'description' => 'Displays a showcase item on the page.'
        ];
    }

    public function defineProperties()
    {
        return [
            'paramId' => [
                'description' => 'The URL route parameter used for looking up the item by its slug.',
                'title'       => 'Slug param name',
                'default'     => 'slug',
                'type'        => 'string'
            ]
        ];
    }

    public function onRun()
    {
        $this->item = $this->page['showcaseItem'] = $this->loadItem();
    }

    protected function loadItem()
    {
        $slug = $this->param($this->property('paramId'));
        return ShowcaseItem::isPublished()->where('slug', '=', $slug)->first();
    }
}