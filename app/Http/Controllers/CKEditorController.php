<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CKEditorController extends Controller
{
    public function upload(Request $request)
    {
        if ($request->hasFile('upload')) {
            $file = $request->file('upload');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('public/uploads', $filename);

            $url = Storage::url($path);

            $funcNum = $request->input('CKEditorFuncNum');
            $message = 'Upload ảnh thành công!';
            echo "<script>window.parent.CKEDITOR.tools.callFunction($funcNum, '$url', '$message');</script>";
        }
    }
}
