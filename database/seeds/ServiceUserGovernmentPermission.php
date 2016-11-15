<?php

use Illuminate\Database\Seeder;

class ServiceUserGovernmentPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
           DB::table('service_users_permission')->insert([
            'id'         => 6,
            'contract_type_id'      => '1',
            'service_prvdr_benf_id' => '2',
            'benf_est'              => '0',
            'benf_indv'             => '0',
            'benf_gover'            => '1',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);
    }
}
