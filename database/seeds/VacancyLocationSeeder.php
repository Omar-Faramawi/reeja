<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class VacancyLocationSeeder extends Seeder
{
   
    public function run()
    {
		factory(\Tamkeen\Ajeer\Models\VacancyLocations::class, 10)->create();
    }
}
