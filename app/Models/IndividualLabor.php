<?php

namespace Tamkeen\Ajeer\Models;

use Illuminate\Database\Eloquent\Model;
use Tamkeen\Ajeer\Models\Job;

class IndividualLabor extends BaseModel
{
    protected $table = 'individual_labors';

    protected $guarded = ['id'];

    /*
     * Get the related job
     */
    public function job()
    {
        return $this->belongsTo(Job::class, 'job_id');
    }

    /*
     * Get related Individual record
     */
    public function individual()
    {
        return $this->belongsTo(Individual::class, 'indviduals_id_number');
    }
}