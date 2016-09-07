<?php

use Illuminate\Database\Seeder;

class ActivitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $mol = new \Tamkeen\Ajeer\Repositories\MOL\MolDataDummyRepository();

        foreach ($mol->fetchActivities() as $key => $activity) {
            factory(\Tamkeen\Ajeer\Models\Activity::class)->create([
                'name'       => $activity,
            ]);
        }
    }
}
