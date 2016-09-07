<?php

use Illuminate\Database\Seeder;
use Tamkeen\Ajeer\Models\IshaarType;

class IshaarTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $notice_types = [
            [
                'id'         => 1,
                'created_at' => '2016-06-27 08:36:32',
                'updated_at' => '2016-06-27 08:36:32',
                'created_by' => 1,
                'name'       => 'taqawel',
            ],
            [
                'id'         => 2,
                'created_at' => '2016-06-27 12:22:35',
                'updated_at' => '2016-06-27 12:22:37',
                'created_by' => 1,
                'name'       => 'temp_work',
            ],
            [
                'id'         => 3,
                'created_at' => '2016-06-27 12:22:35',
                'updated_at' => '2016-06-27 12:22:37',
                'created_by' => 1,
                'name'       => 'hire_labor',
            ],
            [
                'id'         => 4,
                'created_at' => '2016-06-27 12:22:35',
                'updated_at' => '2016-06-27 12:22:37',
                'created_by' => 1,
                'name'       => 'direct_emp',
            ],
            [
                'id'         => 5,
                'created_at' => '2016-06-27 12:22:35',
                'updated_at' => '2016-06-27 12:22:37',
                'created_by' => 1,
                'name'       => 'taqawel_free',
            ],
            [
                'id'         => 6,
                'created_at' => '2016-06-27 12:22:35',
                'updated_at' => '2016-06-27 12:22:37',
                'created_by' => 1,
                'name'       => 'taqawel_paid',
            ],
        ];
        foreach ($notice_types as $notice_type) {
            factory(IshaarType::class)->create(
                $notice_type
            );
        }
    }
}
