<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Category;
use App\Models\Event;

class DashboardController extends Controller
{

    public function index()
    {
        // Fetch all categories, images, and events without pagination
        $categories = Category::all();
        $images = Image::all();
        $events = Event::with(['category', 'image'])->orderBy('begin_date')->get(); // Remove pagination here

        return view('dashboard', compact('categories', 'images', 'events'));
    }

}