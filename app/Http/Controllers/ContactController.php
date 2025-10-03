<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function submit(Request $request)
    {
        // Validation
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email',
            'message' => 'required|string|max:1000',
        ]);

        // هنا ممكن تبعتها على ايميل أو تخزنها في DB
        return back()->with('success', 'Your message has been sent successfully!');
    }
}
