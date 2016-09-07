<?php

use Illuminate\Database\Seeder;
use Tamkeen\Ajeer\Models\ServiceUsersPermission;

class ServiceUserPermissionSeeder extends Seeder
{
    private $data = [
        [
            'contract_type_id'      => '1',
            'service_prvdr_benf_id' => '1',
            'benf_est'              => '1',
            'benf_indv'             => '0',
            'benf_gover'            => '1',
        ],
        [
            'contract_type_id'      => '1',
            'service_prvdr_benf_id' => '3',
            'benf_est'              => '0',
            'benf_indv'             => '1',
            'benf_gover'            => '0',
        ],
        [
            'contract_type_id'      => '2',
            'service_prvdr_benf_id' => '1',
            'benf_est'              => '0',
            'benf_indv'             => '1',
            'benf_gover'            => '0',
        ],
        [
            'contract_type_id'      => '3',
            'service_prvdr_benf_id' => '3',
            'benf_est'              => '0',
            'benf_indv'             => '1',
            'benf_gover'            => '0',
        ],
        [
            'contract_type_id'      => '4',
            'service_prvdr_benf_id' => '2',
            'benf_est'              => '0',
            'benf_indv'             => '1',
            'benf_gover'            => '0',

        ]
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < count($this->data); $i++) {
            factory(ServiceUsersPermission::class)->create(['id' => $i + 1] + $this->data[$i]);
        }
    }
}
