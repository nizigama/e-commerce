<?php

namespace App\Http\Requests\Auth;

use App\Classes\User;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public User $user;
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "email" => ["required", "email:rfc,dns"],
            "password" => ["required", "min:6"]
        ];
    }

    /**
     * Handle a passed validation attempt.
     *
     * @return void
     */
    protected function passedValidation()
    {
        $email = $this->validated("email");
        $password = $this->validated("password");

        $this->user = new User(email: $email, password: $password);
    }
}
