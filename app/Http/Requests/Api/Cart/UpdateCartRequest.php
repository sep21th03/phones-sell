<?php

namespace App\Http\Requests\Api\Cart;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateCartRequest extends FormRequest
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
            'product_variant_id' => 'required|numeric|exists:product_variants,id',
            'quantity' => [
                'required',
                'integer',
                'min:0',
                'max:100',
                function ($attribute, $value, $fail) {
                    $productVariant = \App\Models\ProductVariant::find($this->product_variant_id);
                    if ($productVariant && $value > $productVariant->stock) {
                        $fail('Số lượng vượt quá số lượng sản phẩm trong kho');
                    }
                },
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'product_variant_id.required' => 'Vui lòng chọn sản phẩm',
            'product_variant_id.exists' => 'Sản phẩm không tồn tại',
            'quantity.required' => 'Vui lòng nhập số lượng',
            'quantity.integer' => 'Số lượng phải là số',
            'quantity.min' => 'Số lượng phải lớn hơn hoặc bằng 1',
            'quantity.max' => 'Số lượng phải nhỏ hơn hoặc bằng 100',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors()->all();

        throw new HttpResponseException(jsonResponse('error', $errors));
    }
}
