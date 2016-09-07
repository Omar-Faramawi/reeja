<?php

use Illuminate\Database\Seeder;
use Tamkeen\Ajeer\Models\Bundle;

class BundlesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // The free bundle
        Bundle::create([
            'min_of_num_ishaar' => 5,
            'max_of_num_ishaar' => 5,
            'monthly_amount'    => 0,
            'status'            => 1,
        ]);
        
        //Test Bundle
        Bundle::create([
            'min_of_num_ishaar' => 10,
            'max_of_num_ishaar' => 100,
            'monthly_amount'    => 5,
            'status'            => 1,
        ]);
    }
}
