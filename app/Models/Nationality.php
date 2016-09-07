<?php

namespace Tamkeen\Ajeer\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Nationality extends BaseModel
{

    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'nationalities';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'eng_name',
        'abbr',
        'created_by',
        'updated_by',
    ];

    /**
     * Nationality for job has one nationlityForIshaarJob
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function nationalityForJob()
    {
        return $this->hasOne(NationalityForJob::class, 'nationality_id');
    }

    /**
     * Nationality for job has one nationlityForIshaarJob
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function hrPool()
    {
        return $this->hasOne(HRPool::class, 'nationality_id');
    }

    /**
     * Vacancy has one nationality
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function vacancy()
    {
        return $this->hasOne(Vacancy::class, 'nationality_id');
    }
}