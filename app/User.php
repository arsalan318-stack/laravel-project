<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Product;
use Carbon\Carbon;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','phone','last_seen',
    ];
    
    protected $dates = ['last_seen']; 

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function products()
{
    return $this->hasMany(Product::class);
}
public function favorites()
{
    return $this->belongsToMany(Product::class, 'favorites')->withTimestamps();
}
public function isOnline()
{
    return $this->last_seen && $this->last_seen->gt(Carbon::now()->subMinutes(2));
}

}
