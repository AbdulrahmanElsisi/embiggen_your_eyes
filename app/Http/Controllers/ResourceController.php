<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ResourceController extends Controller
{
    public function index()
    {
        // لينكات resources اللي جبتها من NASA
        $resources = [
            ['name' => 'NASA Worldview', 'url' => 'https://worldview.earthdata.nasa.gov/'],
            ['name' => 'Mars Reconnaissance Orbiter', 'url' => 'https://pds-imaging.jpl.nasa.gov/volumes/mro.html'],
            ['name' => 'EarthData', 'url' => 'https://search.earthdata.nasa.gov/'],
            ['name' => 'Solar System Treks', 'url' => 'https://trek.nasa.gov/'],
        ];

        return view('resources.index', compact('resources'));
    }
}
