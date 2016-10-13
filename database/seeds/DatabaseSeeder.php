<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $this->call(RegionsSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(NationalitySeeder::class);
        $this->call(IshaarTypesSeeder::class);
        $this->call(PermissionsActivitiesModuleSeeder::class);
        $this->call(ContractLocationSeeder::class);
        $this->call(EstablishmentPermissionActivitiesSeeder::class);
        $this->call(EstSizesSeeder::class);
        $this->call(GovernmentPermissionActivitiesSeeder::class);
//        $this->call(VacancySeeder::class);
//        $this->call(HRPoolSeeder::class);
        $this->call(QualificationSeeder::class);
        $this->call(ExperienceSeeder::class);
//        $this->call(GovernmentSeeder::class);
//        $this->call(EstablishmentSeeder::class);
//        $this->call(IndividualSeeder::class);
        $this->call(JobSeeder::class);
        $this->call(ReasonSeeder::class);
        //$this->call(MarketTaqaualServicesTableSeeder::class);
        $this->call(ContractNatureTableSeeder::class);
        $this->call(IshaarSetupSeeder::class);
        $this->call(BundlesSeeder::class);
        $this->call(AttachmentsSeeder::class);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
