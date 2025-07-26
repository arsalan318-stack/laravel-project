<?php

namespace App;
use App\category;
use App\DynamicField;
use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    protected $fillable = [
        'category_id','name', 'description', 'image','status'
    ];

    public function category()
{
    return $this->belongsTo(Category::class);
}
public function fields()
{
    return $this->hasMany(DynamicField::class);
}

}
