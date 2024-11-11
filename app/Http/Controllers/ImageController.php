<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $image = Image::findOrFail($id);

        $image->name = $request->input('name');
        $image->description = $request->input('description');
        $image->save();

        return response()->json(['success' => true, 'message' => 'Image updated successfully']);
    }
}
