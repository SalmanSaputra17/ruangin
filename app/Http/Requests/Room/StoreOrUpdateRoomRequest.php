<?php

namespace App\Http\Requests\Room;

use App\Support\Constant;
use Illuminate\Foundation\Http\FormRequest;

class StoreOrUpdateRoomRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->role === Constant::ROLE_ADMIN;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'        => 'required|string|max:100',
            'location'    => 'nullable|string|max:100',
            'capacity'    => 'required|integer|min:1',
            'description' => 'nullable|string',
            'is_active'   => 'boolean',
        ];
    }
}
