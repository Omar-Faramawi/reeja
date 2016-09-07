<?php

use Illuminate\Database\Seeder;

class IndividualSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\Tamkeen\Ajeer\Models\Individual::class, 20)->create();
    }
}
