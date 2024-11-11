<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Category; 
use App\Models\Image;

use Illuminate\Http\Request;

class TimelineController extends Controller
{
    public function index(Request $request)
    {
        $categoryIds = $request->input('categories', []);

        // Fetch events with their related category and image
        $events = Event::whereIn('category_id', $categoryIds)
            ->with(['category', 'image']) 
            ->orderBy('begin_date')
            ->get();

        return response()->json(['data' => $events]);
    }
}
