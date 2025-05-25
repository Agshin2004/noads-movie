<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNowWatchingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'movie_or_show_id' => ['prohibited'],
            'media_type' => ['prohibited'],
            'season' => ['integer'],
            'episode' => ['integer'],
            'left_time' => ['integer'],
            'runtime' => ['integer'],
        ];
    }
}
