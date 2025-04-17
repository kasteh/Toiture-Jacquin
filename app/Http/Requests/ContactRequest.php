<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
           'name' => 'nullable',
           'code' => 'nullable|numeric',
           'email'=> 'nullable|email',
           'phone'=> 'required',
           'message' => 'required'
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
           'code.numeric' => "Veuillez entrer un code postal valide",
           'email.email' => "Veuillez entrer une adresse email valide",
           'phone.required' => "Veuillez votre numéro de téléphone",
           'message.required' => "Veuillez votre message",
       ];
       return $messages;
   }
}
