<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExploreController extends Controller
{
    public function show($planet = 'earth')
    {
        // لو مفيش باراميتر يرجع Earth
        return view('explore', compact('planet'));
    }

    public function aiSearch(Request $request)
    {
        $query = $request->input('query');

        // حالياً: نرجع إحداثيات ثابتة (Demo)
        // بعدين نربطها بـ Python أو API للـ AI
        return response()->json([
            "success" => true,
            "x" => 0.3,
            "y" => 0.4,
            "width" => 0.2,
            "height" => 0.2
        ]);
    }
}
