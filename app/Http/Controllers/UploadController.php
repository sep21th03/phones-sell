<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UploadController extends Controller
{
    public function uploadImage(Request $request)
    {
        if ($request->hasFile('upload')) {
            $file = $request->file('upload');
            
            $fileName = Str::random(40) . '.' . $file->getClientOriginalExtension();
            
            $path = $file->storeAs('uploads', $fileName, 'public');
            
            return response()->json([
                'url' => asset('storage/' . $path)
            ]);
        }
        
        return response()->json([
            'error' => [
                'message' => 'Upload failed'
            ]
        ], 400);
    }
}