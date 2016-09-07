<?php

use Illuminate\Database\Seeder;
use Tamkeen\Ajeer\Models\ContractBeneficial;

class ContractBeneficialsSeeder extends Seeder
{
    private $beneficials = [
        [
            'contract_provider_id'     => '1',
            'service_prvdr_benf_id' => '1',
            'created_by'               => '1',
        ],
        [
            'contract_provider_id'     => '1',
            'service_prvdr_benf_id' => '2',
            'created_by'               => '1',
        ],
        [
            'contract_provider_id'     => '1',
            'service_prvdr_benf_id' => '3',
            'created_by'               => '1',
        ]
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < count($this->beneficials); $i++) {
            factory(ContractBeneficial::class)->create(['id' => $i + 1] + $this->beneficials[$i]);
        }
    }
}
