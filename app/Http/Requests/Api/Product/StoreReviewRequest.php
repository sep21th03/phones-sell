<?php

namespace App\Http\Requests\Api\Product;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreReviewRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'product_id.required' => 'Vui lòng chọn sản phẩm',
            'product_id.exists' => 'Sản phẩm không tồn tại',
            'rating.required' => 'Vui lòng chọn điểm đánh giá',
            'rating.integer' => 'Điểm đánh giá phải là số',
            'rating.min' => 'Điểm đánh giá phải lớn hơn hoặc bằng 1',
            'rating.max' => 'Điểm đánh giá phải nhỏ hơn hoặc bằng 5',
            'comment.required' => 'Vui lòng nhập đánh giá',
            'comment.max' => 'Đánhgiá tối đa 255 ký tự',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors()->all();

        throw new HttpResponseException(jsonResponse(0, $errors));
    }
}
