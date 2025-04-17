<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class ContentUpdateRequest extends FormRequest
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
           'category_id'=>'required|exists:categories,id',
           'title' => 'required',
           'text' => 'required',
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
           'category_id.required' => "Veuillez sélectionner une catégorie",
           'category_id.exists' => "La catégorie que vous avez sélectionné n'éxiste pas",
           'title.required' => "Veuillez entrer un titre",
           'text.required' => "Veuillez entrer votre texte",
       ];
       return $messages;
   }
}
