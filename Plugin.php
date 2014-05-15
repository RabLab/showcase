<?php

namespace RabLab\Showcase;

class Plugin extends \System\Classes\PluginBase
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
}