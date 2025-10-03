<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class NasaController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('q'); // بدل query من JSON → q من URL

        if (!$query) {
            return response()->json([
                'error' => 'Please provide query ?q=keyword'
            ]);
        }

        // شرط: لو مجرد keyword search
        if (strlen($query) < 20) {
            $res = Http::get('https://images-api.nasa.gov/search', [
                'q' => $query
            ]);
            return $res->json();
        }

        // لو AI/NLP request → نرسل للـ Python
        $res = Http::post('http://127.0.0.1:5000/ai-search', [
            'query' => $query
        ]);
        return $res->json();
    }
}
