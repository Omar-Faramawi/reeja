<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Tamkeen\Ajeer\Models\ContractSetup;
use Tamkeen\Ajeer\Models\ContractType;

class ContractTypeSetupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    private $contractTypes = [
        [
            'id'         => 1,
            'created_at' => '2016-06-27 08:36:32',
            'updated_at' => '2016-06-27 08:36:32',
            'created_by' => 1,
            'name'       => 'taqawel',
            'parent_id'  => null
        ],
        [
            'id'         => 2,
            'created_at' => '2016-06-27 12:22:35',
            'updated_at' => '2016-06-27 12:22:37',
            'created_by' => 1,
            'name'       => 'temp_work',
            'parent_id'  => null
        ],
        [
            'id'         => 3,
            'created_at' => '2016-06-27 12:22:35',
            'updated_at' => '2016-06-27 12:22:37',
            'created_by' => 1,
            'name'       => 'hire_labor',
            'parent_id'  => 2
        ],
        [
            'id'         => 4,
            'created_at' => '2016-06-27 12:22:35',
            'updated_at' => '2016-06-27 12:22:37',
            'created_by' => 1,
            'name'       => 'direct_emp',
            'parent_id'  => 2
        ],
        [
            'id'         => 5,
            'created_at' => '2016-06-27 12:22:35',
            'updated_at' => '2016-06-27 12:22:37',
            'created_by' => 1,
            'name'       => 'taqawel_free',
            'parent_id'  => 1
        ],
        [
            'id'         => 6,
            'created_at' => '2016-06-27 12:22:35',
            'updated_at' => '2016-06-27 12:22:37',
            'created_by' => 1,
            'name'       => 'taqawel_paid',
            'parent_id'  => 1
        ]

    ];

    private $contractSetups = [
        [
            'id'                     => '1',
            'contract_type_id'       => '1',
            'min_accept_period'      => '1',
            'min_accept_period_type' => '1',
            'max_accept_period_type' => '1',
            'created_by'             => '1'
        ],
        [
            'id'                     => '2',
            'contract_type_id'       => '2',
            'min_accept_period'      => '1',
            'min_accept_period_type' => '1',
            'max_accept_period_type' => '1',
            'created_by'             => '1'
        ],
        [
            'id'                     => '3',
            'contract_type_id'       => '3',
            'min_accept_period'      => '1',
            'min_accept_period_type' => '1',
            'max_accept_period_type' => '1',
            'created_by'             => '1'
        ],
        [
            'id'                     => '4',
            'contract_type_id'       => '4',
            'min_accept_period'      => '1',
            'min_accept_period_type' => '1',
            'max_accept_period_type' => '1',
            'created_by'             => '1'
        ]
    ];
    
    /**
     * Run the seeding
     */
    public function run()
    {
        Model::unguard();

        for ($i = 0; $i < count($this->contractTypes); $i++) {
            factory(ContractType::class)->create($this->contractTypes[$i]);
        }

        for ($i = 0; $i < count($this->contractSetups); $i++) {
            factory(ContractSetup::class)->create($this->contractSetups[$i]);
        }

        Model::reguard();
    }
}
