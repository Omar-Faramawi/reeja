<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class ContractLocationSeeder extends Seeder
{
   
    public function run()
    {
		factory(\Tamkeen\Ajeer\Models\ContractLocation::class, 10)->create();
    }
}
