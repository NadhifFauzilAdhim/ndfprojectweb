<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LinkShare extends Model
{
    use HasFactory;

    protected $fillable = ['link_id', 'shared_with'];

    public function link()
    {
        return $this->belongsTo(Link::class);
    }

    public function sharedWith()
    {
        return $this->belongsTo(User::class, 'shared_with');
    }
}
