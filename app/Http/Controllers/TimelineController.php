<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TimelineController extends Controller
{
    public function show($planet = 'earth')
    {
        $timelineData = [
            "2000" => "https://openseadragon.github.io/example-images/highsmith/highsmith.dzi",
            "2010" => "https://openseadragon.github.io/example-images/highsmith/highsmith.dzi",
            "2020" => "https://openseadragon.github.io/example-images/highsmith/highsmith.dzi",
        ];

        return view('timeline', compact('planet', 'timelineData'));
    }

    public function compareImages(Request $request)
    {
        $request->validate([
            'file1' => 'required|image|max:5120',
            'file2' => 'required|image|max:5120',
        ]);

        $file1 = $request->file('file1')->store('public/tmp');
        $file2 = $request->file('file2')->store('public/tmp');

        $path1 = storage_path('app/'.$file1);
        $path2 = storage_path('app/'.$file2);

        $outputDir = storage_path('app/public/tmp');
        if (!file_exists($outputDir)) mkdir($outputDir, 0755, true);
        $outputPath = $outputDir . '/output.jpg';

        // Python environment
        $pythonPath = "C:/Users/Fujitsu/miniconda3/envs/cv/python.exe";

        $command = escapeshellcmd("$pythonPath " . base_path('python-service/compare.py') . " $path1 $path2 $outputPath");
        exec($command, $output, $returnCode);

        if ($returnCode !== 0 || !file_exists($outputPath)) {
            return response()->json(['error' => 'Python script failed'], 500);
        }

        return response()->json([
            'output' => asset('storage/tmp/output.jpg') . '?t=' . time()
        ]);
    }
}
