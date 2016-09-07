<?php namespace Tamkeen\Ajeer\Services\MOL;

interface MolServices
{
    /**
     * get laborer data from MOL database
     *
     * @param $idNumber
     * @param $labor_office
     * @param $sequence_number
     * @return
     */
    public function getLaborerData($idNumber, $labor_office, $sequence_number);
}
