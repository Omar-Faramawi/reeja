<?php

use Illuminate\Database\Seeder;

class EstablishmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\Tamkeen\Ajeer\Models\Establishment::class, 20)->create();
    }
}
