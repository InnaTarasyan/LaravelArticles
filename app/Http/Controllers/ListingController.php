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

    public function show(Listing $listing, Request $request)
    {
        return view('listings.show', compact('listing'));
    }

    public function apply(Listing $listing, Request $request)
    {
        $listing->clicks()
            ->create([
                'user_agent' => $request->userAgent(),
                'ip' => $request->ip()
            ]);

        return redirect()->to($listing->apply_link);
    }
}
