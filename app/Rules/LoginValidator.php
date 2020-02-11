<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class LoginValidator implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if ($this->validateEmail($value) || $this->validateCpf($value)) {
            return true;
        }
        return false;
    }

    /**
     * Validate that an attribute is a valid e-mail address.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function validateEmail($value)
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
    }

    /**
     * Validar um CPF
     *
     * @param string $value
     * @return bool
     */
    public function validateCpf($value): bool
    {
        $c = $this->sanitize($value);

        if (mb_strlen($c) != 11 || preg_match("/^{$c[0]}{11}$/", $c)) {
            return false;
        }

        for (
            $s = 10, $n = 0, $i = 0; $s >= 2; $n += $c[$i++] * $s--
        ) {
        }

        if ($c[9] != ((($n %= 11) < 2) ? 0 : 11 - $n)) {
            return false;
        }

        for (
            $s = 11, $n = 0, $i = 0; $s >= 2; $n += $c[$i++] * $s--
        ) {
        }

        if ($c[10] != ((($n %= 11) < 2) ? 0 : 11 - $n)) {
            return false;
        }

        return true;
    }

    public function sanitize($value): string
    {
        return preg_replace('/[^\d]/', '', $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'O Login deve ser um email ou CPF válido.';
    }
}
