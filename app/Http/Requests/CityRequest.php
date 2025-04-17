<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class CityRequest extends FormRequest
{
    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {

        $this->merge([
            'slug' => Str::slug($this->name).'-'.$this->code
        ]);
    }

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
           'departement_id' => 'required|exists:departements,id',
           'name' => 'required',
           'slug' => 'unique:App\City,slug',
           'code' => 'required|numeric'
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
           'departement_id.required' => "Veuillez sélectionner un département",
           'departement_id.exists' => "Le département que vous avez sélectionné n'éxiste pas",
           'name.required' => "Veuillez entrer un nom pour cette ville",
           'slug.unique' => "Le nom est déjà utiliser, veuillez le modifier",
           'code.required' => "Veuillez entrer le code de la ville",
           'code.numeric' => "Le code n'est pas valide",
       ];
       return $messages;
   }
}
