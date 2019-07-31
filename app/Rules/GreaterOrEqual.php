<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class GreaterOrEqual implements Rule
{

    protected $target;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($param)
    {
        $this->target = $param;
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
        return (float)$value >= (float)$this->target;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Value must be greater or equal than :attribute.';
    }
}
