<?php

use Illuminate\Database\Seeder;

class EstablishmentPermissionActivitiesSeeder extends Seeder
{
    private $data = [
        [
            'service_users_permission_id' => '1',
            'activity_id'                 => '1',
            'provider'                    => '1',
            'benf'                        => '0',
            'benf_activity'               => '0',
            'borrow_pct'                  => '50',
            'loan_pct'                    => '40',
            'created_by'                  => '1',
        ],
        [
            'service_users_permission_id' => '1',
            'activity_id'                 => '2',
            'provider'                    => '1',
            'benf'                        => '0',
            'benf_activity'               => '1',
            'borrow_pct'                  => '30',
            'loan_pct'                    => '70',
            'created_by'                  => '1',
        ],
        [
            'service_users_permission_id' => '1',
            'activity_id'                 => '3',
            'provider'                    => '1',
            'benf'                        => '1',
            'benf_activity'               => '0',
            'borrow_pct'                  => '60',
            'loan_pct'                    => '55',
            'created_by'                  => '1',
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
            factory(\Tamkeen\Ajeer\Models\EstablishmentPermissionActivity::class)->create($this->data[$i]);
        }

    }
}
