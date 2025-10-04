<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index(Request $request){
        $allPlanets = [
            ['name'=>'moon', 'type'=>'moon', 'thumb'=>asset('https://images-assets.nasa.gov/image/PIA00404/PIA00404~large.jpg'), 'image'=>asset('https://images-assets.nasa.gov/image/PIA00404/PIA00404~large.jpg')],
            ['name'=>'mars', 'type'=>'mars', 'thumb'=>asset('https://assets.science.nasa.gov/dynamicimage/assets/science/psd/photojournal/pia/pia24/pia24543/PIA24543.jpg?w=21969&h=14501&fit=clip&crop=faces%2Cfocalpoint'), 'image'=>'https://assets.science.nasa.gov/dynamicimage/assets/science/psd/photojournal/pia/pia24/pia24543/PIA24543.jpg?w=21969&h=14501&fit=clip&crop=faces%2Cfocalpoint'],
            ['name'=>'earth', 'type'=>'earth', 'thumb'=>asset('https://assets.science.nasa.gov/dynamicimage/assets/science/psd/photojournal/pia/pia18/pia18033/PIA18033.jpg?w=8000&h=8000&fit=clip&crop=faces%2Cfocalpoint'), 'image'=>asset('https://assets.science.nasa.gov/dynamicimage/assets/science/psd/photojournal/pia/pia18/pia18033/PIA18033.jpg?w=8000&h=8000&fit=clip&crop=faces%2Cfocalpoint')],
            ['name'=>'saturn', 'type'=>'saturn', 'thumb'=>asset('https://assets.science.nasa.gov/dynamicimage/assets/science/psd/photojournal/pia/pia21/pia21345/PIA21345.jpg?w=3545&h=1834&fit=clip&crop=faces%2Cfocalpoint'), 'image'=>asset('https://assets.science.nasa.gov/dynamicimage/assets/science/psd/photojournal/pia/pia21/pia21345/PIA21345.jpg?w=3545&h=1834&fit=clip&crop=faces%2Cfocalpoint')],
            ['name'=>'jupiter', 'type'=>'jupiter', 'thumb'=>asset('https://assets.science.nasa.gov/dynamicimage/assets/science/psd/photojournal/pia/pia21/pia21974/PIA21974.jpg?w=3805&h=1288&fit=clip&crop=faces%2Cfocalpoint'), 'image'=>asset('https://assets.science.nasa.gov/dynamicimage/assets/science/psd/photojournal/pia/pia21/pia21974/PIA21974.jpg?w=3805&h=1288&fit=clip&crop=faces%2Cfocalpoint')],
            // أضف المزيد حسب الحاجة
        ];

        // Search
        if($request->has('search') && $request->search != ''){
            $allPlanets = array_filter($allPlanets, function($p) use ($request){
                return stripos($p['name'], $request->search) !== false;
            });
        }

        // Filter
        if($request->has('filter') && $request->filter != ''){
            $allPlanets = array_filter($allPlanets, function($p) use ($request){
                return $p['type'] === $request->filter;
            });
        }

        // Pagination (simple)
        $page = $request->get('page', 1);
        $perPage = 4;
        $total = count($allPlanets);
        $planets = array_slice($allPlanets, ($page-1)*$perPage, $perPage);

        return view('gallery', [
            'planets' => $planets,
            'page' => $page,
            'perPage' => $perPage,
            'total' => $total,
            'search' => $request->search ?? '',
            'filter' => $request->filter ?? '',
        ]);
    }
}
