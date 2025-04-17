<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
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
            'email'=> 'required|email|unique:users,email',
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
            'email.email' => "Veuillez entrer une adresse email valide",
            'email.required' => "Veuillez entrer une adresse email",
            'email.unique' => "Quelqu'un utilise déjà cette adresse email !",
        ];
        return $messages;
    }
}
