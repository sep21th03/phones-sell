<?php

namespace App\Http\Requests\Api\User;

use App\Models\User;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateUserRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'phone' => [
                'required',
                'numeric',
                'unique:users,phone',
                function ($attribute, $value, $fail) {
                    if (strlen($value) != 10) {
                        $fail('Số điện thoại khách hàng phải gồm 10 chữ số.');
                    }
                    if (substr($value, 0, 1) != '0') {
                        $fail('Số điện thoại khách hàng phải bắt đầu bằng số 0.');
                    }
                },
            ],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Vui lòng nhập tên',
            'name.string' => 'Định dạng tên phải là chuỗi',
            'name.max' => 'Độ dài tên không được vượt quá 255 kí tự',
            'phone.required' => 'Vui lòng nhập số điện thoại',
            'phone.numeric' => 'Sai định dạng số điện thoại',
            'phone.unique' => 'Số điện thoại đã được đăng ký',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors()->all();

        throw new HttpResponseException(jsonResponse('error', $errors));
    }
}
