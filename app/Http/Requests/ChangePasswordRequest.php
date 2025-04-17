<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
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
           'old_password' => 'required',
           'password' => 'required|confirmed',
           'password_confirmation' => 'required'
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
           'old_password.required' => "Veuillez entrer votre ancien mot de passe",
           'password.required' => "Veuillez entrer votre le nouveau mot de passe",
           'password.confirmed' => "Les deux mots de passe sont differents",
           'password_confirmation.required' => "Veuillez confirmer votre mot de passe",
       ];
       return $messages;
   }
}
