<?php

namespace App\Http\Requests\Admin\ProductColor;


use Illuminate\Foundation\Http\FormRequest;

class StoreProductColorRequest extends FormRequest
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
            'product_id' => 'required|integer',
            'rom_id' => 'required|integer',
            'color' => 'required|string|max:255',
            'color_code' => 'required|string|max:7',
            'price' => 'required|string|max:255',
            'availability' => 'required|integer',
            'stock' => 'required|integer',
            'image_url' => 'required|image|mimes:jpg,png,jpeg,gif,webp|max:2048',
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
            'product_id.required' => 'Mã sản phẩm không được b�� trống.',
            'product_id.integer' => 'Mã sản phẩm phải là một số.',
            'rom_id.required' => 'Mã điện thoại không được bỏ trống.',
            'rom_id.integer' => 'Mã điện thoại phải là một số.',
            'color.required' => 'Màu sắc không được bỏ trống.',
            'color.string' => 'Màu sắc phải là một chuỗi.',
            'image.image' => 'File phải là một ảnh.',
            'image.mimes' => 'Ảnh phải có định dạng jpeg, png, jpg, gif, svg hoặc webp.',
            'image.max' => 'Kích thước ảnh không được lớn hơn 2MB.',
        ];
    }
}
