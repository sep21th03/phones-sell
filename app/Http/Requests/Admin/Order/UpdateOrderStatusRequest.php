<?php

namespace App\Http\Requests\Admin\Order;

use App\Models\Order;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateOrderStatusRequest extends FormRequest
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
            'id' => 'required|exists:orders,id',
            'status' => 'required|in:' . Order::STATUS_SUCCESS . ',' . Order::STATUS_WAITING . ',' . Order::STATUS_CANCEL . ',' . Order::STATUS_CONFIRM . ',' . Order::STATUS_SHIPPING.','.Order::STATUS_WAITING_PAYMENT,
        ];
    }

    public function messages(): array
    {
        return [
            'order_id.required' => 'Vui lòng chọn đơn hàng',
            'order_id.exists' => 'Đơn hàng không tồn tại',
            'status.required' => 'Vui lòng chọn trạng thái đơn hàng',
            'status.in' => 'Trạng thái đơn hàng không hợp lệ',
        ];
    }

    public function attributes(): array
    {
        return [
            'order_id' => 'Đơn hàng',
            'status' => 'Trạng thái đơn hàng',
        ];
    }

    public function getData()
    {
        return $this->validated();
    }

    public function failedValidation(Validator $validator)
    {
        $errors = $validator->errors()->all();
        throw new HttpResponseException(jsonResponse('error', $errors));
    }
}
