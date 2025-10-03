<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AnnotateController extends Controller
{
    public function show()
    {
        return view('annotate');
    }

    public function save(Request $request)
    {
        $request->validate([
            'image' => 'required|string'
        ]);

        $imageData = $request->image;
        // إزالة prefix base64
        $imageData = str_replace('data:image/png;base64,', '', $imageData);
        $imageData = str_replace(' ', '+', $imageData);

        $fileName = 'annotated_' . time() . '.png';
        $path = storage_path('app/public/annotated/' . $fileName);

        // تأكد إن المجلد موجود
        if (!file_exists(dirname($path))) {
            mkdir(dirname($path), 0755, true);
        }

        file_put_contents($path, base64_decode($imageData));

        return response()->json(['path' => asset('storage/annotated/' . $fileName)]);
    }
}
