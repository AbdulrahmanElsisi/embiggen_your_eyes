<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ImageSearchController extends Controller
{
    public function show()
    {
        return view('image_search'); // اسم الـ Blade file
    }

    public function search(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:5120',
            'object' => 'required|string'
        ]);

        $image = $request->file('image');
        $object = $request->object;

        $response = Http::attach(
            'image', file_get_contents($image->getRealPath()), $image->getClientOriginalName()
        )->post('http://127.0.0.1:5002/search', [
            'object' => $object
        ]);

        if ($response->failed()) {
            return back()->with('error', 'Failed to detect objects.');
        }

        $data = $response->json();

        // الصورة الناتجة (يمكن تعمل route proxy لو تحب)
        $outputPath = $data['path'] ?? null;

        return view('image_search', compact('outputPath'));
    }
}
