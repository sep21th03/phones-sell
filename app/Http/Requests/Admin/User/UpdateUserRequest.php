<?php

namespace App\Http\Requests\Admin\User;

use App\Models\User;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        $currentUserId = Auth::id();
        $inputUserId = $this->input('id');

        return $inputUserId != $currentUserId;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id' => 'required|exists:users,id',
            'role' => 'required|exists:roles,name',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,'. $this->id,
            'password' => 'nullable|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20|unique:users,phone,'. $this->id,
            'address' => 'nullable|string|max:25'
        ];
    }

    public function messages()
    {
        return [
            'id.required' => 'Vui lòng chọn người dùng',
            'id.exists' => 'Người dùng không tồn tại trong hệ thống',
            'role.required' => 'Vui lòng chọn vai trò',
            'role.exists' => 'Vai trò không tồn tại',
            'name.required' => 'Vui lòng nhập tên',
            'name.string' => 'Tên phải là chữ',
            'name.max' => 'Tên không quá 255 ký tự',
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email không đúng định dạng',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors()->all();
        throw new HttpResponseException(jsonResponse('error', $errors));
    }

    public function failedAuthorization()
    {
        $errors = ['Bạn không thể chỉnh sửa thông tin của chính bạn.'];
        throw new HttpResponseException(jsonResponse('error', $errors));
    }
}
