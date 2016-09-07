<?php

use Illuminate\Database\Seeder;

class GovernmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\Tamkeen\Ajeer\Models\Government::class, 20)->create();
    }
}
