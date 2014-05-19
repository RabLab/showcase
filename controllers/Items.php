<?php namespace RabLab\Showcase\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use RabLab\Showcase\Models\Item;

class Items extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';

    public $bodyClass = 'compact-container';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('RabLab.Showcase', 'showcase', 'items');
        $this->addCss('/plugins/rablab/showcase/assets/css/rablab.showcase-preview.css');
        $this->addCss('/plugins/rablab/showcase/assets/css/rablab.showcase-preview-theme-default.css');

        $this->addCss('/plugins/rablab/showcase/assets/vendor/prettify/prettify.css');
        $this->addCss('/plugins/rablab/showcase/assets/vendor/prettify/theme-desert.css');

        $this->addJs('/plugins/rablab/showcase/assets/js/item-form.js');
        $this->addJs('/plugins/rablab/showcase/assets/vendor/prettify/prettify.js');
    }

    public function onRefreshPreview()
    {
        $data = post('Item');

        $previewHtml = Item::formatHtml($data['content'], true);

        return [
            'preview' => $previewHtml
        ];
    }
}