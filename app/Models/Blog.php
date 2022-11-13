<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Blog extends Model
{
    use HasFactory;

    public function description(): Attribute
    {
        return new Attribute(
            get: fn ($value) => strtoupper($value),
                 set: fn ($value) => $value,
        );
    }

    public function search($searchText)
    {
       return  \DB::table('blog')
           ->whereFullText('long_description', $searchText)
           ->get();
    }
}
