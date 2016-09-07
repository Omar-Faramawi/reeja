<?php

use Illuminate\Database\Seeder;

class HRPoolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\Tamkeen\Ajeer\Models\HRPool::class, 10)->create(['provider_id'=>'1', 'provider_type' => '3']);
    }
}
