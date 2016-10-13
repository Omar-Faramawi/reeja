<?php

namespace Tamkeen\Ajeer\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Job.
 */
class Job extends BaseModel
{

    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ad_jobs';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * Jobs has many ishaars
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function ishaars()
    {
        return $this->belongsToMany(IshaarSetup::class, 'ishaar_job')->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ishaarJobs()
    {
        return $this->hasOne(IshaarJob::class, 'job_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function attachments()
    {
        return $this->belongsToMany(Attachment::class, 'attachment_for_job', 'job_id', 'attachment_id');
    }

    /**
     * Job has one vacancy
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function vacancy()
    {
        return $this->hasOne(Vacancy::class, 'job_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function nationalities()
    {
        return $this->belongsToMany(Nationality::class, 'nationality_job', 'job_id', 'nationality_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function nationalitiesnotices()
    {
        return $this->belongsToMany(Nationality::class, 'nationality_for_job', 'ishaar_job_id', 'nationality_id');
    }

    /**
     * @return mixed
     */
    public function getNationalityListAttribute()
    {
        return $this->nationalities->pluck('id')->toArray();
    }

    /**
     * Getting allowed jobs for the logged in user based on his nationality.\
     * @param $query
     * @param null $select
     * @param $nationality_id
     * @return mixed
     */
    public function scopeAllowed($query, $select = null, $nationality_id)
    {
        $jobs = static::whereHas('ishaarJobs', function ($ishaar_job_q) use ($nationality_id) {
            $ishaar_job_q->whereHas('nationalities', function ($nat_for_job_q) use ($nationality_id) {
                $nat_for_job_q->where('nationality_id', $nationality_id);
            });
        });

        return isset($select) ? $jobs->pluck(...$select) : $jobs->get();
    }
}
