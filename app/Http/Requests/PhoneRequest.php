<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PhoneRequest extends FormRequest
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
        $rules = [
            'phone'=> 'required'
        ]; 
        return $rules;
    }
  
    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {        
        $messages = [
            'phone.required' => "Veuillez votre numéro de téléphone",
        ];
        return $messages;
    }
}
