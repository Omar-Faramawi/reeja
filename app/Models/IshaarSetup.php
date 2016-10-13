<?php

namespace Tamkeen\Ajeer\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Tamkeen\Ajeer\Utilities\Constants;
use Carbon\Carbon;
class IshaarSetup extends BaseModel
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ishaar_setup';

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
     * ishaar setups that belong to ishaar types
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type()
    {
        return $this->belongsTo(IshaarType::class, 'ishaar_type_id');
    }

    /**
     * Ishaar setups that has many jobs
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function jobs()
    {
        return $this->belongsToMany(Job::class, 'ishaar_jobs', 'ishaar_setup_id', 'job_id')->withTimestamps();
    }

    /**
     * Ishaar setups belongs to regions
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function regions()
    {
        return $this->belongsToMany(Region::class, 'ishaar_regions', 'ishaar_setup_id', 'regions_id')->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function notices()
    {
        return $this->hasOne(ContractEmployee::class, 'ishaar_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ishaarjobs()
    {
        return $this->hasMany(IshaarJob::class, 'ishaar_setup_id');
    }

    /**
     * @param $query
     *
     * @return mixed
     */
    public function scopeTempWork($query)
    {
        return $query->whereIn('ishaar_type_id', [2, 3, 4]);
    }

    public function scopeTaqawel($query)
    {
        return $query->where('ishaar_type_id', Constants::CONTRACTTYPES['taqawel']);
    }

     /**
     * @param $max_ishaar_period
     * @param $max_ishaar_period_type
     *
     * @return num of days
     */
    public static function calcMaxPeriodInDays($max_period, $type){
        $now  = Carbon::now();
        switch ($type){
            case 0:
                return $max_period;
            case 1:
                return $now->diffInDays($now->copy()->addMonths($max_period));
            case 2:
                return $now->diffInDays($now->copy()->addYears($max_period));

        }
    }

    public function scopeTaqawelPaid($query)
    {
        return $query->where('ishaar_type_id', Constants::CONTRACTTYPES['taqawel_paid']);
    }

    public function scopeTaqawelFree($query)
    {
        return $query->where('ishaar_type_id',Constants::CONTRACTTYPES['taqawel_free']);
    }

    /**
     * @param $max_ishaar_period
     * @param $max_ishaar_period_type
     *
     * @return num of months
     */
    public static function calcMaxPeriodInMonths($max_date, $type){
        $now  = Carbon::now();
        switch ($type){
            case 1:
                return $max_date;
            case 0:
                return $now->diffInMonths($now->copy()->addDays($max_date));
            case 2:
                return $now->diffInMonths($now->copy()->addYears($max_date));

        }
    }

    /**
     * @param $max_date
     * @param $minimun_date
     *
     * @return num of months
     */
    public static function calcTwoDatesDiffInMonths($min_date, $max_date){
        $now  = Carbon::now();
        $max = new Carbon($max_date);
        $min = new Carbon($min_date);
        $difference = $max->diff($min)->days;
        return $now->diffInMonths($now->copy()->addDays($difference));
    }
}
