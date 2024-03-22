<?php

namespace App\Helpers;

use Illuminate\Validation\Rules\Password;

class PasswordValidator
{
    public static function rules(): array
    {
        return [
           "required", "confirmed", Password::min(8)->letters()->mixedCase()->numbers()->symbols()
        ];
    }
}
