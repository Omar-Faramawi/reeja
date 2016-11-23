<?php

namespace Tamkeen\Ajeer\Validators;


class PhoneNumberValidator
{
    public function validatePhoneNumber($attribute, $value, $parameters, $validator)
    {
        return ctype_digit($value);
    }
}