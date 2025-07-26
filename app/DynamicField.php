<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Subcategory;

class DynamicField extends Model
{
    protected $fillable = [
        'subcategory_id',
        'field_name',
        'field_type',
        'field_options',
    ];
    
    protected $casts = [
        'field_options' => 'array',
    ];
    
    public function Subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }
}
