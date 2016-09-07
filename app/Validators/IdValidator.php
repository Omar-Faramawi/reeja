<?php

namespace Tamkeen\Ajeer\Validators;

use Tamkeen\Platform\Model\Common\HijriDate;
use Tamkeen\Platform\Model\NIC\IdNumber;
use Tamkeen\Platform\NIC\Repositories\Citizens\CitizenDataNotFoundException;
use Tamkeen\Platform\NIC\Repositories\Foreigners\ForeignerDataNotFoundException;

class IdValidator extends Validator
{
    /**
     * Check if this number is valid NID or Iqama number
     *
     * @param $idNumber
     *
     * @return bool
     */
    protected function checksumId($idNumber)
    {
        $sum    = 0;
        $digits = str_split($idNumber);
    
        for ($i = 0; $i < 10; ++$i) {
            if ($i % 2 == 0) {
                $s = $digits[$i] * 2;
                $sum += $s % 10 + floor($s / 10);
            } else {
                $sum += $digits[$i];
            }
        }
    
        return $sum % 10 === 0;
    }
    
    /**
     * @param $attribute
     * @param $value
     * @param $parameters
     *
     * @return bool
     */
    public function validateSaudiNationalOrIqamaId($attribute, $value, $parameters)
    {
        if ($this->checksumId($value) == 1) {
            if (substr($value, 0, 1) == "1" && $parameters != 0) {
                try {
                    $this->citizen = $this->citizensNic->fetchCitizen(IdNumber::fromString($value),
                        HijriDate::fromDate(intval($parameters[0]), intval($parameters[1]), intval($parameters[2])),
                        IdNumber::fromInt(config('nic.operatorId')));
                
                    return isset($this->citizen);
                } catch (CitizenDataNotFoundException $e) {
                    return false;
                }
            } else {
                try {
                    $this->foreigner = $this->foreignersNic->fetchForeigner(IdNumber::fromString($value),
                        IdNumber::fromInt(config('nic.operatorId')));
                
                    return isset($this->foreigner);
                } catch (ForeignerDataNotFoundException $e) {
                    return false;
                }
            }
        } else {
            return false;
        }
    }
}
