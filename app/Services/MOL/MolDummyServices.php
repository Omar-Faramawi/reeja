<?php namespace Tamkeen\Ajeer\Services\MOL;

use Illuminate\Support\Arr;
use Tamkeen\Ajeer\Services\MOL\Exceptions\LaborerNotFound;

class MolDummyServices implements MolServices
{
    /**
     * @var array
     */
    private $data;
    
    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }
    
    /**
     * get laborer data from mol config file
     *
     * @param $idNumber
     * @param $labor_office
     * @param $sequence_number
     * @return array
     */
    public function getLaborerData($idNumber, $labor_office, $sequence_number)
    {
        $data = $this->laborers()->first(function ($_, $laborer) use ($idNumber, $labor_office, $sequence_number) {
            if (
                $laborer['id_number'] == $idNumber
                and $laborer['labor_office_id'] == $labor_office
                and $laborer['sequence_number'] == $sequence_number
            ) {
                return $laborer;
            }
        }, function () {
            throw new LaborerNotFound();
        });
        
        return $data;
    }
    
    /**
     * @return \Illuminate\Support\Collection
     */
    private function laborers()
    {
        return collect(Arr::get($this->data, 'laborers', []));
    }
}