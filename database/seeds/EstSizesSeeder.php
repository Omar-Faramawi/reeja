<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class EstSizesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        
        factory(\Tamkeen\Ajeer\Models\EstablishmentSize::class)->create([
            'name'                    => 'ضئيل',
            'pct_hire_labor_tmp_work' => 10,
            'created_by'              => '1',
        ]);
        factory(\Tamkeen\Ajeer\Models\EstablishmentSize::class)->create([
            'name'                    => 'صغير',
            'pct_hire_labor_tmp_work' => 10,
            'created_by'              => '1',
        ]);
        factory(\Tamkeen\Ajeer\Models\EstablishmentSize::class)->create([
            'name'                    => 'متوسط',
            'pct_hire_labor_tmp_work' => 10,
            'created_by'              => '1',
        ]);
        factory(\Tamkeen\Ajeer\Models\EstablishmentSize::class)->create([
            'name'                    => 'كبير',
            'pct_hire_labor_tmp_work' => 10,
            'created_by'              => '1',
        ]);
        
        factory(\Tamkeen\Ajeer\Models\EstablishmentSize::class)->create([
            'name'                    => 'ضخم',
            'pct_hire_labor_tmp_work' => 10,
            'created_by'              => '1',
        ]);
        
        Model::reguard();
    }
}
