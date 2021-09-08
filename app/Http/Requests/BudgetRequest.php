<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;

class BudgetRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|min:3|max:255',
            'client_id' => 'required|min:1|max:255',
            'date' => 'required|min:3|max:255',
            'address' => 'required|min:3|max:255',
            'currency' => 'required|min:1|max:255',
            'payment_method' => 'required|min:1|max:255',
            'status' => 'required|min:1|max:255',
            'social_laws_amount' => 'required|min:1|max:255',
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            //
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'title.required' => "El campo objeto es obligatorio"
        ];
    }
}
