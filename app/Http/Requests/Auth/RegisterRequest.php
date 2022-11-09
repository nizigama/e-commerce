<?php

namespace App\Http\Requests\Auth;

use App\Classes\User;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            "names" => ["required", "string", "min:2"],
            "email" => ["required", "email:rfc,dns"],
            "password" => ["required", "min:6", "confirmed"]
        ];
    }

    /**
     * Handle a passed validation attempt.
     *
     * @return void
     */
    protected function passedValidation()
    {
        $names = $this->validated("names");
        $email = $this->validated("email");
        $password = $this->validated("password");

        $this->user = new User(names: $names, email: $email, password: $password);
    }
}
