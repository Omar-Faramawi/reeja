<?php

use Illuminate\Database\Seeder;

class MarketTaqaualServicesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('market_taqaual_services')->delete();
        
        \DB::table('market_taqaual_services')->insert(array (
            0 => 
            array (
                'id' => 3,
                'contract_nature_id' => 1,
                'description' => 'some fake description',
                'provider_or_benf' => '1',
                'service_prvdr_benf_id' => 3,
                'service_id' => 1,
                'status' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}
