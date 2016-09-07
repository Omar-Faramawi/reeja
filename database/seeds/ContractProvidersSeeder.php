<?php

use Illuminate\Database\Seeder;
use Tamkeen\Ajeer\Models\ContractProvider;

class ContractProvidersSeeder extends Seeder
{
    private $providers = [
        [
            'contract_type_id'      => '1',
            'service_prvdr_benf_id' => '1',
            'created_by'            => 1,
            'updated_by'            => 1,
        ],
        [
            'contract_type_id'      => '2',
            'service_prvdr_benf_id' => '1',
            'created_by'            => 1,
            'updated_by'            => 1,
        ],
        [
            'contract_type_id'      => '2',
            'service_prvdr_benf_id' => '2',
            'created_by'            => 1,
            'updated_by'            => 1,
        ],
        [
            'contract_type_id'      => '2',
            'service_prvdr_benf_id' => '3',
            'created_by'            => 1,
            'updated_by'            => 1,
        ],
        [
            'contract_type_id'      => '3',
            'service_prvdr_benf_id' => '1',
            'created_by'            => 1,
            'updated_by'            => 1,
        ],
        [
            'contract_type_id'      => '1',
            'service_prvdr_benf_id' => '1',
            'created_by'            => 1,
            'updated_by'            => 1,
        ],
        [
            'contract_type_id'      => '2',
            'service_prvdr_benf_id' => '1',
            'created_by'            => 1,
            'updated_by'            => 1,
        ],
        [
            'contract_type_id'      => '3',
            'service_prvdr_benf_id' => '3',
            'created_by'            => 1,
            'updated_by'            => 1,
        ]
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < count($this->providers); $i++) {
            factory(ContractProvider::class)->create(['id' => $i + 1] + $this->providers[$i]);
        }
    }
}
