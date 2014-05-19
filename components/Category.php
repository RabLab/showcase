<?php namespace RabLab\Showcase\Components;

use Cms\Classes\ComponentBase;
use RabLab\Showcase\Models\Category as ShowcaseCategory;
use Cms\Classes\CmsPropertyHelper;
use App;
use Redirect;

class Category extends ComponentBase
{
    public $category;
    public $itemPage;
    public $items;

    public function componentDetails()
    {
        return [
            'name'        => 'Showcase Category',
            'description' => 'Displays items from a specific category.'
        ];
    }

    public function defineProperties()
    {
        return [
            'paramId' => [
                'description' => 'The URL route parameter used for looking up the category by its slug.',
                'title'       => 'Slug param name',
                'default'     => 'slug',
                'type'        => 'string'
            ],
            'itemPage' => [
                'title' => 'Item page',
                'description' => 'Name of the showcase item page file for the "Learn more" links. This property is used by the default component partial.',
                'type'=>'dropdown',
                'default' => 'showcase/item'
            ],
            'itemsPerPage' => [
                'title' => 'Items per',
                'default' => '10',
                'type'=>'string',
                'validationPattern'=>'^[0-9]+$',
                'validationMessage'=>'Invalid format of the items per page value'
            ],
            'noItemsMessage' => [
                'title' => 'No items message',
                'description' => 'Message to display in the showcase item list in case if there are no items. This property is used by the default component partial.',
                'type'=>'string',
                'default' => 'No items found'
            ]
        ];
    }

    public function getItemPageOptions()
    {
        return CmsPropertyHelper::listPages();;
    }

    public function onRun()
    {
        $this->category = $this->page['category'] = $this->loadCategory();
        $this->itemPage = $this->page['itemPage'] = $this->property('itemPage');

        if ($this->category) {
            $this->items = $this->page['items'] = $this->loadItems();

            $currentPage = $this->param('page');
            if ($currentPage > ($lastPage = $this->items->getLastPage()) && $currentPage > 1)
                return Redirect::to($this->controller->currentPageUrl(['page'=>$lastPage]));
        }
    }

    protected function loadCategory()
    {
        $slug = $this->param($this->property('paramId'));
        return ShowcaseCategory::where('slug', '=', $slug)->first();
    }

    protected function loadItems()
    {
        $currentPage = $this->param('page');
        App::make('paginator')->setCurrentPage($currentPage);

        return $this->category->items()->paginate($this->property('itemsPerPage'));
    }
}