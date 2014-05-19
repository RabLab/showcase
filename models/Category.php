<?php namespace RabLab\Showcase\Models;

use Str;
use Model;
use RabLab\Showcase\Models\Item;

class Category extends Model
{
    public $table = 'rablab_showcase_categories';

    /*
     * Validation
     */
    public $rules = [
        'name' => 'required',
        'slug' => 'required|between:3,64|unique:rablab_showcase_categories',
        'code' => 'unique:rablab_showcase_categories',
    ];

    protected $guarded = [];

    public function beforeValidate()
    {
        // Generate a URL slug for this model
        if (!$this->exists && !$this->slug)
            $this->slug = Str::slug($this->name);
    }

    public function items()
    {
        // @todo: declare this relationship as the class field when the conditions option is implemented
        return $this->belongsToMany('RabLab\Showcase\Models\Item', 'rablab_showcase_items_categories')->isPublished()->orderBy('published_at', 'desc');
    }

    public function itemCount()
    {
        return $this->items()->count();
    }
}