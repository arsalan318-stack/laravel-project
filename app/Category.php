<?php

namespace App;
use App\Subcategory;
use App\Product;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name', 'description', 'image','status'
    ];

    public function subcategories()
{
    return $this->hasMany(Subcategory::class);
}

public function products()
{
    return $this->hasMany(Product::class);
}

}
