<?php namespace RabLab\Showcase;

/**
 * The plugin.php file (called the plugin initialization script) defines the plugin information class.
 */

use Backend;
use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function pluginDetails()
    {
        return [
            'name' => 'Showcase Plugin',
            'description' => 'Provides a showcase of products or services for a business or personal showcase.',
            'author' => 'Fabricio Pereira Rabelo',
            'icon' => 'icon-share'
        ];
    }
    
    public function registerNavigation()
    {
        return [
            'showcase' => [
                'label'       => 'Showcase',
                'url'         => Backend::url('rablab/showcase/items'),
                'icon'        => 'icon-share',
                'permissions' => ['rablab.showcase.*'],
                'order'       => 500,

                'subMenu' => [
                    'items' => [
                        'label'       => 'Items',
                        'icon'        => 'icon-asterisk',
                        'url'         => Backend::url('rablab/showcase/posts'),
                        'permissions' => ['rablab.showcase.access_posts'],
                    ],
                    'categories' => [
                        'label'       => 'Categories',
                        'icon'        => 'icon-list',
                        'url'         => Backend::url('rablab/showcase/categories'),
                        'permissions' => ['rablab.showcase.access_categories']
                    ],
                ]

            ]
        ];
    }
}