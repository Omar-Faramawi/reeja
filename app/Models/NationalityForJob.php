<?php

namespace Tamkeen\Ajeer\Models;



/**
 * Class NationalityForJob.
 */
class NationalityForJob extends BaseModel
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'nationality_for_job';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];
    

    /**
     * ishaar jobs belongs to ishaar job
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ishaarJob()
    {
        return $this->belongsTo(IshaarJob::class, 'ishaar_job_id');
    }

    /**
     * nationalityForJobs belongs to nationality 
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function nationalityDetails()
    {
        return $this->belongsTo(Nationality::class, 'nationality_id');
    }
}
