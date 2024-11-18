<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user(){
       return $this->belongsTo(User::class);
    }
    public function getRouteKeyName()
    {
        return 'slug';
    }
    public function visithistory()
    {
        return $this->hasMany(Linkvisithistory::class);
    }
    public function blockedip(){
        return $this->hasMany(BlockedIp::class);
    }
}
