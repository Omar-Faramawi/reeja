<?php

namespace Tamkeen\Ajeer\Validators;


class GreaterThanValidator
{
    public function validateGreaterThan($attribute, $value, $parameters, $validator)
    {
        $periods_map = [0, 1, 30, 365];
        $data = $validator->getData();

        $min_field = $parameters[0];
        $min_field = $data[$min_field];

        if (isset($parameters[1]) && isset($parameters[2])) {
            $min_period_type = $parameters[1];
            $min_period_type = $data[$min_period_type];

            $max_period_type = $parameters[2];
            $max_period_type = $data[$max_period_type];

            return intval($value) * $periods_map[$max_period_type] > intval($min_field) * $periods_map[$min_period_type];
        } else {
            return intval($value) > intval($min_field);
        }
    }
}