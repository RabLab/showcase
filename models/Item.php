<?php namespace RabLab\Showcase\Models;

use Str;
use Model;
use October\Rain\Support\Markdown;
use October\Rain\Support\ValidationException;
use RabLab\Showcase\Classes\TagProcessor;

class Item extends Model
{
    public $table = 'rablab_showcase_items';

    /*
     * Validation
     */
    public $rules = [
        'title' => 'required',
        'slug' => ['required', 'regex:/^[a-z0-9\/\:_\-\*\[\]\+\?\|]*$/i'],
        'content' => 'required',
        'excerpt' => ''
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['published_at'];

    /*
     * Relations
     */
    public $belongsTo = [
        'user' => ['Backend\Models\User']
    ];

    public $belongsToMany = [
        'categories' => ['RabLab\Showcase\Models\Category', 'table' => 'rablab_showcase_items_categories', 'order' => 'name']
    ];

    public $attachMany = [
        'featured_images' => ['System\Models\File', 'order' => 'sort_order'],
        'content_images' => ['System\Models\File', 'order' => 'sort_order']
    ];

    public $preview = null;

    public static function formatHtml($input, $preview = false)
    {
        $result = Markdown::parse(trim($input));

        if ($preview)
            $result = str_replace('<pre>', '<pre class="prettyprint">', $result);

        $result = TagProcessor::instance()->processTags($result, $preview);

        return $result;
    }

    public function afterValidate()
    {
        if ($this->published && !$this->published_at)
            throw new ValidationException([
               'published_at' => 'Please specify the published date'
            ]);
    }

    public function scopeIsPublished($query)
    {
        return $query
            ->whereNotNull('published')
            ->where('published', '=', 1)
        ;
    }

    public function beforeCreate()
    {
	if($this->published_at)
	{
	    $timestamp = strtotime($this->published_at);
	    $this->published_at = date('Y-m-d', $timestamp) . ' ' . date('H:i:s');
	}
    }
    
    public function beforeUpdate()
    {
	// Original date
	$original = $this->original;
	$org_timestamp = strtotime($original['published_at']);
	$org_published_at = date('Y-m-d', $org_timestamp);
	// current date
	$timestamp = strtotime($this->published_at);
	$published_at = date('Y-m-d', $timestamp);
	
	if($published_at != $org_published_at)
	{
	    $this->published_at = $published_at . ' ' . date('H:i:s');
	}
	else
	{
	    $this->published_at = date('Y-m-d H:i:s', $org_timestamp);
	}
    }
    
    public function beforeSave()
    {	
        $this->content_html = self::formatHtml($this->content);
    }
}