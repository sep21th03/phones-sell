<?php

namespace App\Http\Requests\Admin\Product;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Kiểm tra quyền của người dùng nếu cần
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'info' => 'nullable|string',
            'description' => 'nullable|string',
            'category_id' => 'required|integer|exists:categories,id',
            'discount' => 'nullable|numeric|min:0',
            'screen_size' => 'nullable|string',
            'screen_resolution' => 'nullable|string',
            'screen_type' => 'nullable|string',
            'ram' => 'nullable|string',
            'memory_card_slot' => 'nullable|string',
            'battery' => 'nullable|string',
            'camera_front' => 'nullable|string',
            'camera_rear' => 'nullable|string',
            'sim' => 'nullable|string',
            'operating_system' => 'nullable|string',
            'connectivity' => 'nullable|string',
            'bluetooth' => 'nullable|string',
            'pin' => 'nullable|string',
            'chip' => 'nullable|string',
            'dimensions' => 'nullable|string',
            'weight' => 'nullable|string',
            'rom_id' => 'required|integer',
            'color' => 'required|string',
            'color_code' => 'required|string',
            'stock' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'availability' => 'required|boolean',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Vui lòng nhập tên sản phẩm.',
            'title.string' => 'Tên sản phẩm phải là một chuỗi.',
            'title.max' => 'Tên sản phẩm không được quá 255 ký tự.',
            'info.string' => 'Thông tin sản phẩm phải là một chuỗi.',
            'category_id.required' => 'Vui lòng chọn danh mục sản phẩm.',
            'category_id.integer' => 'Danh mục sản phẩm phải là một số nguyên.',
            'category_id.exists' => 'Danh mục sản phẩm không tồn tại.',
            'discount.numeric' => 'Giá trị giảm giá phải là một số.',
            'discount.min' => 'Giá trị giảm giá không được nhỏ hơn 0.',
            'stock.required' => 'Vui lòng nhập số lượng tồn kho.',
            'stock.integer' => 'Số lượng tồn kho phải là một số nguyên.',
            'stock.min' => 'Số lượng tồn kho không được nhỏ hơn 0.',
            'price.required' => 'Vui lòng nhập giá sản phẩm.',
            'price.numeric' => 'Giá sản phẩm phải là một số.',
            'color.required' => 'Vui lòng nhập màu',
            'price.min' => 'Giá sản phẩm không được nhỏ hơn 0.',
            'availability.required' => 'Vui lòng xác định tình trạng có sẵn của sản phẩm.',
            'availability.boolean' => 'Tình trạng có sẵn phải là đúng hoặc sai.',
            'image.image' => 'File phải là một ảnh.',
            'image.mimes' => 'Ảnh phải có định dạng jpeg, png, jpg, gif, svg hoặc webp.',
            'image.max' => 'Kích thước ảnh không được lớn hơn 2MB.',
        ];
    }
}
