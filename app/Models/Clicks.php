<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clicks extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function listings()
    {
        return $this->belongsTo(Listing::class);
    }
}
