<?php

use Illuminate\Database\Seeder;

class VacancySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        factory(\Tamkeen\Ajeer\Models\Vacancy::class, 10)->create([
            'benf_id' => factory(\Tamkeen\Ajeer\Models\Establishment::class)->create()->id,
            'benf_type' => '3',
            'job_id' => rand(1, 3),
            'nationality_id' => rand(1, 2)
        ]);

    }
}
