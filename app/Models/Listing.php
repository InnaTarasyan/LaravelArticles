<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Listing extends Model
{
    use HasFactory, Searchable;

    protected $guarded = [];

    public function clicks()
    {
        return $this->hasMany(Clicks::class);
    }

    public function user()
    {
        $this->belongsTo(User::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    /**
     * @return array
     */
    public function toSearchableArray()
    {
        return [
            'title'    => $this->title,
            'company'  => $this->company,
            'content'  => $this->content,
            'location' => $this->location,
        ];
    }
}
