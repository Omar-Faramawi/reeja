<?php

use Illuminate\Database\Seeder;
use Tamkeen\Ajeer\Models\Job;
use Tamkeen\Ajeer\Models\Nationality;
use Tamkeen\Ajeer\Repositories\MOL\MolDataDummyRepository;

class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $mol           = new MolDataDummyRepository();
        $nationalities = Nationality::pluck('id')->toArray();
        
        foreach ($mol->fetchJobsLookup(false) as $key => $job) {
            $created_job = Job::firstOrCreate(['job_name' => $job['name'], 'created_by' => 1, 'updated_by' => 1]);
            $created_job->nationalities()->sync($nationalities);
        }
    }
}
