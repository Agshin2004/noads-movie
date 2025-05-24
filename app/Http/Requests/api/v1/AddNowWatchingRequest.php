<?php

namespace App\Http\Requests\api\v1;

use Illuminate\Foundation\Http\FormRequest;

class AddNowWatchingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();  // only authenticated users can create
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'movie_or_show_id' => ['required', 'integer'],
            'media_type' => ['required', 'in:movie,tv'],
            'season' => ['integer'],
            'episode' => ['integer'],
            'left_time' => ['integer'],
            'runtime' => ['integer'],
        ];
    }

    /**
     * Defining Custom Message
     * @return array
     */
    public function messages(): array
    {
        return [
            'media_type.in' => 'Invalid media type, allowed >>> movie, tv'
        ];
    }
}
