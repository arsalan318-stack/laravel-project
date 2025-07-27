<?php

namespace App;
use App\category;
use App\User;
use App\SubCategory;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'user_id','category_id','subcategory_id','type','title', 'description', 'image1','image2','image3','seler_name','phone','hide_phone','location','ad_type','payment_method'
    ];

    protected $casts = [
        'features' => 'array', // This will automatically cast JSON to array and vice versa
    ];
    

    public function category()
{
    return $this->belongsTo(category::class);
}

public function subcategory()
{
    return $this->belongsTo(Subcategory::class);
}

public function user()
{
    return $this->belongsTo(User::class);
}

public function favoritedBy()
{
    return $this->belongsToMany(User::class, 'favorites')->withTimestamps();
}


}
