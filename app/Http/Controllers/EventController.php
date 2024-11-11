<?php

namespace App\Http\Controllers;

use App\Models\Event;

use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:category,id',
            'description' => 'nullable|string',
            'begin_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:begin_date',
            'image_id' => 'nullable|exists:image,id',
        ]);

        $event = Event::create($validated);

        return response()->json(['success' => (bool) $event, 'data' => $event]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $event = Event::findOrFail($id);

        if ($event->delete()) {
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 500);
    }
}
