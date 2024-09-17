<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'summary' => 'required|string',
            'category_id' => 'required|integer|exists:categories,id',
            'article_parts.*.type' => 'required|string|in:text,image',
            'article_parts.*.content' => 'required_if:article_parts.*.type,text',
            'article_parts.*.image_path' => 'required_if:article_parts.*.type,image|file|image|max:2048',
            'article_parts.*.order' => 'required|integer',
        ];
    }
}
