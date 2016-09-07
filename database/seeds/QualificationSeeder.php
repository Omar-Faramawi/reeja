<?php

use Illuminate\Database\Seeder;

class QualificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $qualifications = ['دون الابتدائي','ابتدائي','متوسط','ثانوي','دبلوم','بكالوريوس','دراسات عليا'];
		foreach($qualifications as $qualification){
			factory(\Tamkeen\Ajeer\Models\Qualification::class)->create([
				'name' => $qualification
			]);
		}
    }
}
