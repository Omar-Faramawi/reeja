<?php

use Illuminate\Database\Seeder;

class ExperienceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $experiences = ['أقل من سنة','1-3 سنوات','4-6 سنوات','7-10 سنوات','أكثر من 10 سنوات'];
		foreach($experiences as $experience){
			factory(\Tamkeen\Ajeer\Models\Experience::class)->create([
				'name' => $experience
			]);
		}
    }
}
