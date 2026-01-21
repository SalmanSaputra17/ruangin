<?php

namespace App\Http\Requests\Booking;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
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
            'room_id'         => 'required|exists:rooms,id',
            'title'           => 'required|string|max:150',
            'description'     => 'nullable|string',
            'start_time'      => 'required|date',
            'end_time'        => 'required|date|after:start_time',
            'is_override'     => 'boolean',
            'override_reason' => 'nullable|string',
        ];
    }
}
