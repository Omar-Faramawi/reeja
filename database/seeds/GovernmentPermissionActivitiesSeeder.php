<?php

use Illuminate\Database\Seeder;

class GovernmentPermissionActivitiesSeeder extends Seeder
{
    private $data = [
        [
            'id'                          => '1',
            'activity_id'                 => '1',
            'created_by'                  => 1,
            'updated_by'                  => 1,
            'service_users_permission_id' => 1
        ],
        [
            'id'                          => '2',
            'activity_id'                 => '2',
            'created_by'                  => 1,
            'updated_by'                  => 1,
            'service_users_permission_id' => 1
        ],
        [
            'id'                          => '3',
            'activity_id'                 => '3',
            'created_by'                  => 1,
            'updated_by'                  => 1,
            'service_users_permission_id' => 1
        ],
        [
            'id'                          => '4',
            'activity_id'                 => '4',
            'created_by'                  => 1,
            'updated_by'                  => 1,
            'service_users_permission_id' => 1
        ],
        [
            'id'                          => '5',
            'activity_id'                 => '5',
            'created_by'                  => 1,
            'updated_by'                  => 1,
            'service_users_permission_id' => 1
        ],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < count($this->data); $i++) {
            factory(\Tamkeen\Ajeer\Models\GovernmentPermissionActivity::class)->create($this->data[$i]);
        }

    }
}
