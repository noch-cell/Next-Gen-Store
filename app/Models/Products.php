<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;


class Products extends Model
{

    use HasFactory;
    use HasSlug;
    use SoftDeletes;

    protected $fillable = ['name', 'description', 'price', 'image', 'image_mime', 'image_size', 'created_by', 'updated_by'];

    /** Get the option for generating the slug */

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function categories()
    {
        return $this->belongsToMany(Categories::class, 'product_categories', 'products_id', 'categories_id');
    }
}
