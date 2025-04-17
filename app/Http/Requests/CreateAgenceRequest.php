<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateAgenceRequest extends FormRequest
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
            'agence_name' => 'required',
            'agence_adress' => 'required',
            'agence_owner_name' => 'required',
            'agence_owner_email'=> 'required|email',
            'agence_owner_phone'=> 'required',
            'lat' => 'required',
            'lng' => 'required',
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
            'agence_name.required' => "Veuillez entrer le nom de votre entreprise",
            'agence_adress.required' => "Veuillez entrer votre adresse",
            'agence_owner_email.required' => "Veuillez entrer votre adresse email",
            'agence_owner_email.email' => "Veuillez entrer une adresse email valide",
            'agence_owner_name.required' => "Veuillez votre nom et prénom",
            'agence_owner_phone.required' => "Veuillez votre numéro de téléphone",
            'lat.required' => "Veuillez la latitude de votre adresse",
            'lng.required' => "Veuillez la longitude de votre adresse",
        ];
        return $messages;
    }
}
