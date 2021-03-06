<?php namespace RabLab\Showcase;

use Backend;
use Controller;
use System\Classes\PluginBase;
use RabLab\Showcase\Classes\TagProcessor;

class Plugin extends PluginBase
{

    public function pluginDetails()
    {
        return [
            'name'        => 'Showcase',
            'description' => 'Provides a showcase plugin, can be used to show products, services or until like a photos gallery.',
            'author'      => 'Fabricio Pereira Rabelo',
            'icon'        => 'icon-image'
        ];
    }

    public function registerComponents()
    {
        return [
            'RabLab\Showcase\Components\Item' => 'showcaseItem',
            'RabLab\Showcase\Components\Items' => 'showcaseItems',
            'RabLab\Showcase\Components\Categories' => 'showcaseCategories',
            'RabLab\Showcase\Components\Category' => 'showcaseCategory'
        ];
    }

    public function registerNavigation()
    {
        return [
            'showcase' => [
                'label'       => 'Showcase',
                'url'         => Backend::url('rablab/showcase/items'),
                'icon'        => 'icon-image',
                'permissions' => ['showcase.*'],
                'order'       => 500,

                'sideMenu' => [
                    'items' => [
                        'label'       => 'Items',
                        'icon'        => 'icon-file-text-o',
                        'url'         => Backend::url('rablab/showcase/items'),
                        'permissions' => ['showcase.access_items'],
                    ],
                    'categories' => [
                        'label'       => 'Categories',
                        'icon'        => 'icon-list',
                        'url'         => Backend::url('rablab/showcase/categories'),
                        'permissions' => ['showcase.access_categories'],
                    ],
                ]

            ]
        ];
    }

    public function registerFormWidgets()
    {
        return [
            'RabLab\Showcase\FormWidgets\Preview' => [
                'label' => 'Preview',
                'alias' => 'preview'
            ]
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     */
    public function register()
    {
        /*
         * Register the image tag processing callback
         */

        TagProcessor::instance()->registerCallback(function($input, $preview){
            if (!$preview)
                return $input;

            return preg_replace('|\<img alt="([0-9]+)" src="image"([^>]*)\/>|m',
                '<span class="image-placeholder" data-index="$1">
                    <span class="dropzone">
                        <span class="label">Click or drop an image...</span>
                        <span class="indicator"></span>
                    </span>
                    <input type="file" class="file" name="image[$1]"/>
                    <input type="file" class="trigger"/>
                </span>', 
            $input);
        });
    }
}