<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReportAbuse extends Model
{
    protected $fillable = ['user_id', 'product_id', 'reason', 'details'];

}
