<?php

use Illuminate\Database\Seeder;

class ContractNatureTableSeeder extends Seeder
{
    
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        \DB::table('contract_nature')->insert([
            0 =>
                [
                    'id'         => 1,
                    'name'       => 'بناء وتشييد',
                    'status'     => '1',
                    'created_at' => null,
                    'updated_at' => null,
                    'created_by' => 1,
                    'updated_by' => null,
                    'deleted_at' => null,
                ],
        ]);
    }
}
