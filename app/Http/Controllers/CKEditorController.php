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

            // Lấy URL của ảnh đã upload
            $url = Storage::url($path);

            // CKEditor yêu cầu trả về dưới dạng script
            $funcNum = $request->input('CKEditorFuncNum');
            $message = 'Upload ảnh thành công!';
            echo "<script>window.parent.CKEDITOR.tools.callFunction($funcNum, '$url', '$message');</script>";
        }
    }
}
