<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
          'email' => 'required|exists:users,email|email',
          'password' => 'required',
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
          'email.required' => "Veuillez entrer votre adresse email",
          'email.exists' => "Cette adresse email n'existe pas",
          'email.email' => "Veuillez entrer un adresse email valide",
          'password.required' => "Veuillez entrer votre mot de passe",
      ];
      return $messages;
  }
}
