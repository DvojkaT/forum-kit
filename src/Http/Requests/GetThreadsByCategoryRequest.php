<?php

namespace DvojkaT\Forumkit\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetThreadsByCategoryRequest extends FormRequest
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
     * @return array<string, string>
     */
    public function rules(): array
    {
        return [
            'category_id' => 'required|integer|exists:DvojkaT\Forumkit\Models\ThreadCategory,id'
        ];
    }
}
