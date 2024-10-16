<?php

namespace App\Http\Requests\Api\Order;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

use Illuminate\Http\Exceptions\HttpResponseException;

class VnpayPaymentRequest extends FormRequest
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
            'order_id' => 'required|exists:orders,code',
            'amount' => 'required|integer',
            'url_return' => 'required|url'
        ];
    }

    public function messages(): array
    {
        return [
            'order_id.required' => 'ID đơn hàng là bắt buộc.',
            'order_id.exists' => 'ID đơn hàng không tồn tại.',
            'amount.required' => 'Số tiền là bắt buộc.',
            'amount.integer' => 'Số tiền phải là số nguyên.',
            'url_return.required' => 'URL return là bắt buộc.',
            'url_return.url' => 'URL return không hợp lệ.',
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors()->all();

        throw new HttpResponseException(jsonResponse('error', $errors));
    }
}
