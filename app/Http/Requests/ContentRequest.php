<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class ContentRequest extends FormRequest
{
    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {

        $this->merge([
            'slug' => Str::slug($this->title)
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
           'category_id'=>'required|exists:categories,id',
           'title' => 'required',
           'slug' => 'unique:App\Content,slug',
           'text' => 'required',
           'image' => 'required|image',
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
           'slug.unique' => "Le tite est déjà utiliser, veuillez le modifier",
           'text.required' => "Veuillez entrer votre texte",
           'image.required' => "Veuillez entrer une image",
           'image.image' => "Veuillez entrer une image valide",
       ];
       return $messages;
   }
}
