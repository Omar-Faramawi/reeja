<?php

namespace Tamkeen\Ajeer\Validators;

use InvalidArgumentException;

abstract class Validator
{
    
    /**
     * @param $count
     * @param $parameters
     * @param $rule
     */
    protected function requireParameterCount($count, $parameters, $rule)
    {
        if (count($parameters) < $count) {
            throw new InvalidArgumentException("Validation rule $rule requires at least $count parameters.");
        }
    }
    
}
