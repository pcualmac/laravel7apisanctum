<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Products extends Model
{
    use SoftDeletes;

    protected $table = 'products';

    protected $primaryKey = 'id';

    protected $translatable = [
    ];

    protected $fillable = [
        'product_name',
        'product_desc',
        'product_category',
        'price',
    ];

    protected $visible = [
        'product_name',
        'product_desc',
        'product_category_id',
        'price',
    ];

    protected $appends = ['product_category'];

    public function getDates()
    {
        return [
            'created_at',
            'updated_at',
        ];
    }

    public function product_category()
    {
        return $this->belongsTo('App\ProductCategory', 'product_category_id', 'product_category_id');
    }

    public function getProductCategoryIdsAttribute()
    {
        $category_ids = [];

        foreach ($this->product_categories as $category) {
            $category_ids[] = $category->id;
        }

        return $category_ids;
    }
}
