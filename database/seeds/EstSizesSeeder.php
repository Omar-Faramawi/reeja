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
            'name'                    => 'صغيرة جدا',
            'pct_hire_labor_tmp_work' => 100,
            'created_by'              => '1',
        ]);
        factory(\Tamkeen\Ajeer\Models\EstablishmentSize::class)->create([
            'name'                    => 'صغيرة',
            'pct_hire_labor_tmp_work' => 100,
            'created_by'              => '1',
        ]);
        factory(\Tamkeen\Ajeer\Models\EstablishmentSize::class)->create([
            'name'                    => 'متوسطة',
            'pct_hire_labor_tmp_work' => 100,
            'created_by'              => '1',
        ]);
        factory(\Tamkeen\Ajeer\Models\EstablishmentSize::class)->create([
            'name'                    => 'كبيرة',
            'pct_hire_labor_tmp_work' => 100,
            'created_by'              => '1',
        ]);
        
        factory(\Tamkeen\Ajeer\Models\EstablishmentSize::class)->create([
            'name'                    => 'عملاقة',
            'pct_hire_labor_tmp_work' => 100,
            'created_by'              => '1',
        ]);
        
        Model::reguard();
    }
}
