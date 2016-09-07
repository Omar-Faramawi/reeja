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
        

        \DB::table('contract_nature')->delete();
        
        \DB::table('contract_nature')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'contract_name',
                'status' => '1',
                'created_at' => NULL,
                'updated_at' => NULL,
                'created_by' => 0,
                'updated_by' => NULL,
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}
