<?php

namespace Tamkeen\Ajeer\Validators;

use Illuminate\Database\QueryException;
use Illuminate\Validation\Validator;
use Tamkeen\Ajeer\Models\SaudiPercentage;
use Vinkla\Hashids\Facades\Hashids;

/**
 * Class SaudiPercentageValidator
 * @package Tamkeen\Ajeer\Validators
 */
class SaudiPercentageValidator
{
    /**
     * Custom validation to check if the same saudi percentage records already exists in the database
     *
     * @param $attribute
     * @param $value
     * @param $parameters
     *
     * @return bool
     */
    public function validateSaudiPercentageUnique($attribute, $value, $parameters)
    {

        list(, $providerActivityId, , $benfActivityId, , $providerSizeId, , $benfSizeId, , $saudiPercentageId) = $parameters;

        try {
            $saudiPercentages = SaudiPercentage::where('provider_activity_id', $providerActivityId);

            if ( ! empty($saudiPercentageId)) {
                $saudiPercentages = $saudiPercentages->whereNotIn('id', Hashids::decode($saudiPercentageId));
            }

            $saudiPercentages = $saudiPercentages->where('benf_activity_id', $benfActivityId)
                                                 ->where('provider_size_id', $providerSizeId)
                                                 ->where('benf_size_id', $benfSizeId)
                                                 ->count();

            if ( ! $saudiPercentages) {
                return true;
            }

        } catch (QueryException $e) {
            return false;
        }

        return false;
    }

}
