<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Requests\Admin\Category\DeleteCategoryRequest;
use App\Http\Requests\Admin\Category\StoreCategoryRequest;
use App\Http\Requests\Admin\Category\UpdateCategoryRequest;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $categories = Category::getCategory();
        if ($categories) {
            return response()->json([
                'status' => 'success',
                'message' => 'Danh sách danh mục.',
                'data' => $categories,
            ], 200);
        }
    }

    public function store(StoreCategoryRequest $request)
    {
        try {
            $data = $request->validated();

            $category = Category::create([
                'name' => $data['name'],
            ]);

            if ($category) {
                return jsonResponse('success',  'Tạo danh mục thành công', $category);
            } else {
                return jsonResponse('error', 'Tạo danh mục thất bại');
            }
        } catch (\Exception $e) {
            return jsonResponse('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function update(UpdateCategoryRequest $request)
    {
        try {
            $data = $request->validated();
            $category = Category::find($data['id']);

            if (!$category) {
                return jsonResponse('error', 'Loại sản phẩm không tồn tại!', []);
            }

            $category->name = $request->name;
            $category->save();

            return jsonResponse('success', 'Cập nhật sản phẩm thành công', $category);
        } catch (\Exception $e) {
            return jsonResponse('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }
    public function destroy(DeleteCategoryRequest $request)
    {
        try {
            $data = $request->validated();
            $category = Category::find($data['id']);
            if (!$category) {
                return jsonResponse('error', 'Loại sản phẩm không tồn tại!', []);
            }
            $category->delete_category($data['id']);
            return jsonResponse('success','Xóa loại sản phẩm thành công.');
        } catch (\Exception $e) {
            return jsonResponse('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }
}
