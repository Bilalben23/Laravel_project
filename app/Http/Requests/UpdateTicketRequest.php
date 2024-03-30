<?php

namespace App\Http\Requests;

use App\Enums\TicketStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTicketRequest extends FormRequest
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
            "title" => ["required_without:status","string", "max:255"],
            "description" => ["required_without:status" ,"string"],
            "attachment" => ["sometimes", "file", "mimes:jpg,jpeg,bmp,png,pdf"],
            "status" => ["string", Rule::in(array_column(TicketStatus::cases(), "value"))]
        ];
    }
}