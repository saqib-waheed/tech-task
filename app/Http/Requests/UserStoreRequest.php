<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Allow all for this task
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // On create: method is POST
        $isCreating = $this->isMethod('post');

        return [
            'name'          => 'required|string|max:255',
            'surname'       => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email' . ($isCreating ? '' : ',' . $this->user->id),
            'phone'         => 'required|string|max:20',
            'country'       => 'required|string',
            'gender'        => 'required|in:male,female,other',
            'password'      => $isCreating ? 'required|confirmed|min:6' : 'nullable|confirmed|min:6',
            'profile_image' => 'nullable|image|max:2048',
        ];
    }
}
