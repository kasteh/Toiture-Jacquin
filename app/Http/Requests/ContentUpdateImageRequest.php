<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContentUpdateImageRequest extends FormRequest
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
            'image.required' => "Veuillez entrer une image",
            'image.image' => "Veuillez entrer une image valide",
        ];
        return $messages;
    }
}
