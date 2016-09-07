<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\Tamkeen\Ajeer\Models\UserTypes::class)->create([
            'id'   => 1,
            'name' => 'الإدارة',
        ]);
        factory(\Tamkeen\Ajeer\Models\UserTypes::class)->create([
            'id'   => 2,
            'name' => 'الجهات الحكومية',
        ]);
        factory(\Tamkeen\Ajeer\Models\UserTypes::class)->create([
            'id'   => 3,
            'name' => 'المنشآت',
        ]);
        factory(\Tamkeen\Ajeer\Models\UserTypes::class)->create([
            'id'   => 4,
            'name' => 'فرد سعودي',
        ]);
        factory(\Tamkeen\Ajeer\Models\UserTypes::class)->create([
            'id'   => 5,
            'name' => 'فرد غير سعودي',
        ]);
        factory(\Tamkeen\Ajeer\Models\User::class)->create([
            'id'           => 1,
            'email'        => 'admin@tamkeen.it',
            'name'         => 'Admin',
            'password'     => bcrypt('123456'),
            'user_type_id' => '1',
            'active'       => '1',
        ]);
    }
}
