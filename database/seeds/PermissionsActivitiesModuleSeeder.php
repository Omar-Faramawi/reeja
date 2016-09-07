<?php

use Illuminate\Database\Seeder;

class PermissionsActivitiesModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
            $this->call('ContractTypeSetupSeeder');
            $this->call('ServiceUserPermissionSeeder');
            $this->call('ContractProvidersSeeder');
            $this->call('ContractBeneficialsSeeder');
            $this->call('ActivitiesSeeder');

    }
}
