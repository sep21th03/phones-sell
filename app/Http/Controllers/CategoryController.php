<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(!Auth::check()){
            return response()->json([
               'status' => 'error',
               'message' => 'Bạn cần đăng nhập để thực hiện thao tác này!',
            ], 401);
        }
        if(Auth::user()->role !=1){
            return response()->json([
               'status' => 'error',
               'message' => 'Bạn không có quyền thực hiện thao tác này!',
            ], 403);
        }
        $categories = Category::getCategory();
        if($categories){
            return response()->json([
               'status' =>'success',
               'message' => 'Danh sách danh mục.',
                'data' => $categories,
            ], 200);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if(!Auth::check()){
            return response()->json([
               'status' => 'error',
               'message' => 'Bạn cần đăng nhập để thực hiện thao tác này!',
            ], 401);
        }
        $user = Auth::user();
        if($user->role!= '1'){
            return response()->json([
               'status' => 'error',
               'message' => 'Bạn không có quyền thực hiện thao tác này!',
            ], 403);
        }
        try{
            $request->validate([
                'name' => 'required|string|max:255',
            ]);

            $category = Category::create([
                'name' => $request->name,
            ]);

            return response()->json([
               'status' =>'success',
               'message' => 'Thêm loại sản phẩm thành công.',
                'data' => $category
            ], 201);
        } catch(\Exception $e){
            return response()->json([
               'status' => 'error',
               'message' => $e->getMessage()
            ], 500);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        if(!Auth::check()){
            return response()->json([
               'status' => 'error',
               'message' => 'Bạn cần đăng nhập để thực hiện thao tác này!'
            ],401);
        }
        $user = Auth::user();
        if($user->role != '1'){
            return response()->json([
               'status' => 'error',
               'message' => 'Bạn không có quyền thực hiện thao tác này!'
            ],403);
        }
        try{
            $request->validate([
                'name' => 'required|string|max:255',
            ]);
            $id = $request->id;
            $category = Category::find($id);
            if(!$category){
                return response()->json([
                   'status' => 'error',
                   'message' => 'Loại sản phẩm không tồn tại!'
                ],404);
            }
    
            $category->name = $request->name;
            $category->save();
    
            return response()->json([
               'status' =>'success',
               'message' => 'Category updated successfully.',
                'data' => $category
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
               'status' => 'error',
               'message' => 'Có lỗi xảy ra: '.$e->getMessage()
            ], 500);
        }
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        if(!Auth::check()){
            return response()->json([
               'status' => 'error',
               'message' => 'Bạn cần đăng nhập để thực hiện thao tác này!'
            ],401);
        }
        $user = Auth::user();
        if($user->role != '1'){
            return response()->json([
               'status' => 'error',
               'message' => 'Bạn không có quyền thực hiện thao tác này!'
            ],403);
        }
        try{
            $request->validate([
                'id' =>'required|exists:categories,id'
            ]);
            $id = $request->id;
            $category = Category::find($id);
            if(!$category){
                return response()->json([
                   'status' => 'error',
                   'message' => 'Loại sản phẩm không tồn tại!'
                ],404);
            }
            $category->delete_category($id);
            return response()->json([
               'status' =>'success',
               'message' => 'Xóa loại sản phẩm thành công.'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
               'status' => 'error',
               'message' => 'Có lỗi xảy ra: '.$e->getMessage()
            ], 500);
        }
    }

    public function search(Request $request){
        $query = $request->input('search');

        $categories = Category::search($query);
        if ($categories->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Không tìm thấy loại sản phẩm nào.'
            ], 404);
        }
        return response()->json([
           'status' =>'success',
            'data' => $categories
        ], 200);
    }
}
