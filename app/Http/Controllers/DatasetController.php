<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DatasetController extends Controller
{
    public function index()
    {
        // هنا ممكن بعدين نضيف Array بالكواكب
        $planets = ['Earth', 'Mars', 'Moon', 'Venus', 'Jupiter'];

        return view('datasets', compact('planets'));
    }
}
