<?php

namespace Tamkeen\Ajeer\Models;


/**
 * Class IshaarJob.
 */
class IshaarJob extends BaseModel
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ishaar_jobs';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];


    /**
     *  the ishaar setup belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function setup()
    {
        return $this->belongsTo(IshaarSetup::class, 'ishaar_setup_id');
    }
    
    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function job()
    {
        return $this->belongsTo(Job::class, 'job_id');
    }

    
    /**
     * Ishaar job has many nationalities
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function nationalities()
    {
        return $this->hasMany(NationalityForJob::class, 'ishaar_job_id');
    }
}
