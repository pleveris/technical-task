<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TranzactionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'date' => 'required|date',
            'amount' => 'required|numeric',
            'currency' => 'required',
            'client_id' => 'required'
        ];
    }
}
