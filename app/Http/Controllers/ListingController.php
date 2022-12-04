<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\Tag;
use Illuminate\Http\Request;

class ListingController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('s')) {
            $searchQuery = trim($request->get('s'));
            $query = Listing::search($searchQuery);
        } else {
            $query = Listing::where('is_active', true)
                ->with('tags')
                ->latest();
        }

        $listings = $query->where('is_active', true)->get();

        $tags = Tag::orderBy('name')
            ->get();

       return view('listings.index', compact('listings', 'tags'));
    }
}
