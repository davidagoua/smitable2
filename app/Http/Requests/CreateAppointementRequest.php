<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateAppointementRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'nom'=>'required',
            'prenoms'=>'required',
            'date_naissance'=>'required',
            'lieu_naissance'=>'required',
            'adresse'=>'required',
            'situation_matrimoniale'=>'required',
            'contact'=>'required',
        ];
    }
}
