<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true; // Autoriser l'accès
    }

    public function rules()
    {
        return [
            'category' => 'nullable|string|max:255', // Validation de la catégorie
        ];
    }
}
