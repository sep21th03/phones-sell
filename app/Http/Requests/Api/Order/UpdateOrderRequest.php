<?php

namespace App\Http\Requests\Api\Order;

use App\Rules\PhoneNumberRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateOrderRequest extends FormRequest
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
            'phone' => ['required', 'numeric', new PhoneNumberRule()],
            'address' => 'required',
            'notes' => 'nullable',
            'name' => 'required',
        ];
    }
    function message() {
        return [
            'phone.required' => 'Vui lòng nhập số điện thoại',
            'phone.numeric' => 'Số điện thoại phải là số',
            'address.required' => 'Vui lòng nhập địa chỉ',
            'name.required' => 'Vui lòng nhập tên'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors()->all();

        throw new HttpResponseException(jsonResponse(0, $errors));
    }
}
