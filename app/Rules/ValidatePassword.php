<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Sentinel;
use Hash;

class ValidatePassword implements Rule
{
    protected $user;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->user = Sentinel::getUser();
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return Hash::check($value, $this->user->password);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'You have entered an invalid password.';
    }
}
