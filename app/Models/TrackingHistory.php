<?php

namespace App\Models;

use Dotenv\Repository\Adapter\GuardedWriter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackingHistory extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $casts = [
        'location' => 'array'
    ];

    public function tracking()
    {
        return $this->belongsTo(Tracking::class);
    }   
}
