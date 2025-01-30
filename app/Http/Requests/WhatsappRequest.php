<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class WhatsappRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'branch_id'       => ['required', 'numeric', Rule::unique('whatsapp_order_setup', 'branch_id')->ignore($this->route('whatsappOrderSetup.id'))],
            'phone'           => ['required', 'string', 'max:20'],
            'status'          => ['required', 'numeric', ],
        ];
    }

    public function messages(): array 
    {
        return [
            'branch_id.required' => 'The branch field is required',
            'branch_id.numeric'  => 'The branch field should be numeric',
            'branch_id.unique'   => 'The branch has been already taken',
        ];
    }
}