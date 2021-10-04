<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductCategory extends Model
{
    use SoftDeletes;

    protected $table = 'product_categories';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'parent_id',
        'local',
        'deleted_at',
        'created_at',
        'updated_at',
    ];

    protected $visible = [
        'product_category_id',
        'name',
        'parent_id',
        'local',
        'deleted_at',
        'created_at',
        'updated_at',
    ];

    public function getDates()
    {
        return [
            'created_at',
            'updated_at',
        ];
    }

    public function parent()
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }

    public function children()
    {
        return $this->hasMany(ProductCategory::class, 'parent_id');
    }

    /**
     * Returns a ordered collection of a category's parents.
     *
     * @return collection $parents
     */
    public function getParentsAttribute()
    {
        $parents = collect([]);

        $parent = $this->parent;

        while (!is_null($parent)) {
            $parents->push($parent);
            $parent = $parent->parent;
        }

        return $parents->reverse();
    }

    public function allChildren()
    {
        $all_children = collect([]);
        $children = $this->children;
        while (!empty($children)) {
            $all_children->push($children);
            if (isset($children->children)) {
                $children = $children->children;
            } else {
                $children = null;
            }
        }

        return $all_children->flatten();
    }

    public function product()
    {
        return $this->hasMany('App\Products', 'product_category_id', 'product_category_id');
    }
}
