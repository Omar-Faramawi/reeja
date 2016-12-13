<?php

namespace Tamkeen\Ajeer\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\SoftDeletes;
use Tamkeen\Ajeer\Utilities\Constants;

class HRPool extends BaseModel
{

    use SoftDeletes;

    /**
     * add table name
     */
    protected $table = 'hr_pool';

    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @var array
     */
    protected $appends = ['age', 'gender_name', 'religion_name', 'provider_name', 'job_type_name'];

    /**
     * add deleted_by to timestamps
     */
    protected $dates = ['deleted_at', 'birth_date'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function job()
    {
        return $this->belongsTo(Job::class, 'job_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function experience()
    {
        return $this->belongsTo(Experience::class, 'experience_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function nationality()
    {
        return $this->belongsTo(Nationality::class, 'nationality_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function qualification()
    {
        return $this->belongsTo(Qualification::class, 'qualification_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function region()
    {
        return $this->belongsTo(Region::class, 'region_id');
    }

    /**
     * Get related age
     *
     *
     * @return int
     */
    public function age()
    {
        $date = new \DateTime($this->birth_date);
        $H    = intval($date->format("Y"));
        $G    = $H + 622 - ($H / 33);

        return intval(floor(date("Y")) - $G);

    }

    /**
     * @param $query
     *
     * @return mixed
     *
     * return the Pool related to the current user
     */
    public function scopeByMe($query)
    {
        if (session()->get('selected_establishment')) {
            $query = $query->where('provider_id', session()->get('selected_establishment.id'));
        } elseif (session()->get('government')) {
            $query = $query->where('provider_id', session()->get('government.id'));
        } else {
            $query = $query->where('provider_id', \Auth::user()->id_no);
        }

        return $query->where('provider_type', \Auth::user()->user_type_id);
    }

    /**
     * @param $query
     *
     * @return mixed
     */
    public function scopeByOthers($query)
    {
        if (session()->get('selected_establishment')) {
            $providerId = session()->get('selected_establishment.id');
        } elseif (session()->get('government')) {
            $providerId = session()->get('government.id');
        } else {
            $providerId = auth()->user()->id_no;
        }
        $query->whereRaw('(provider_id != ' . $providerId . ' and provider_type = ' . \Auth::user()->user_type_id . ')');
        $query->orWhereRaw('(provider_id = ' . $providerId . ' and provider_type != ' . \Auth::user()->user_type_id . ')');
        $query->orWhereRaw('(provider_id != ' . $providerId . ' and provider_type != ' . \Auth::user()->user_type_id . ')');

        return $query;
    }

    /**
     * Get the user's HRPool record
     *
     * @param $query
     *
     * @return $query
     */
    public function scopeMe($query)
    {
        return $query->where([
            'id_number'     => auth()->user()->national_id,
            'provider_id'   => auth()->user()->id_no,
            'provider_type' => auth()->user()->user_type_id,
        ]);
    }

    public function scopeNotMe($query) {
        return $query->where("id_number", "!=", auth()->user()->national_id);
    }

    /**
     * @return mixed
     */
    public function getGenderNameAttribute()
    {
        return !is_null($this->gender) ? trans('labels.gender.' . $this->gender) : '';
    }

    /**
     * @return int
     */
    public function getAgeAttribute()
    {
        $date = new \DateTime($this->birth_date);
        $H    = intval($date->format("Y"));
        $G    = $H + 622 - ($H / 33);

        return intval(floor(date("Y")) - $G);
    }

    /**
     * @return mixed
     */
    public function getReligionNameAttribute()
    {
        return !is_null($this->religion) ? trans('labels.religion.' . $this->religion) : '';
    }

    /**
     * @return mixed
     * @internal param $type
     * @internal param $id
     *
     */
    public function getProviderNameAttribute()
    {
        $type = $this->attributes['provider_type'];
        $id   = $this->attributes['provider_id'];
        try {
            switch ($type) {
                case 4:
                case 5:
                    return Individual::findOrFail($id)->name;
                case 2:
                    return Government::findOrFail($id)->name;
                case 3:
                    return Establishment::findOrFail($id)->name;
            }
        } catch (ModelNotFoundException $e) {
            return trans('labels.not_found');
        }
    }

    /**
     * @param $query
     *
     * @return mixed
     */
    public function scopeNotChecked($query)
    {
        return $query->where('chk', '0');
    }

    /**
     * @param $query
     *
     * @return mixed
     */
    public function scopeChecked($query)
    {
        return $query->where('chk', '1');
    }

    /**
     * @return mixed
     *
     * get only muslims
     */
    public function scopeOnlyMuslims()
    {
        return static::where('religion', Constants::RELIGION['muslim']);
    }

    /**
     * @param $column
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function government($column = "provider_id")
    {
        return $this->belongsTo(Government::class, $column);
    }

    /**
     * @param $column
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function individual($column = "provider_id")
    {
        return $this->belongsTo(Individual::class, $column);
    }

    /**
     * @param $column
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function establishment($column = "provider_id")
    {
        return $this->belongsTo(Establishment::class, $column);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function contractEmployee()
    {
        return $this->hasOne(ContractEmployee::class, "id_number");
    }

    /**
     * @param $query
     *
     * @return mixed
     */
    public function scopeNotSeasonal($query)
    {
        return $query->where(function($query) {
            $query->where('region_id', '!=', 1)
                  ->orWhereNull('region_id');
        });
    }

    /**
     * @param $query
     *
     * @return mixed
     */
    public function scopeSeasonal($query)
    {
        return $query->where('region_id', 1);
    }

    /**
     * @return mixed
     */
    public function getJobTypeNameAttribute()
    {
        return !is_null($this->job_type) ? trans(Constants::jobTypes($this->gender)) : '';
    }
    
    /**
     * @param $query
     *
     * @return mixed
     */
    public function scopeJobseeker($query)
    {
        return $query->whereIn('provider_type', [Constants::USERTYPES['saudi'], Constants::USERTYPES['job_seeker']]);
    }

    /**
     * @param $query
     *
     * @return mixed
     */
    public function scopeEmployeedOrVisitor($query){
        return $query->where('id_number','LIKE','4%')
                     ->orWhere('id_number','LIKE','2%');
    }
    
    public function scopeEmployeed($query){
        return $query->where('id_number','LIKE','2%');
    }

    public function scopeVisitor($query){
        return $query->where('id_number','LIKE','4%');
    }

    public function scopeAnyGender($query){
        return $query->where('gender',Constants::GENDER['female'])->orWhere('gender',Constants::GENDER['male']);
    }

    public function scopeOnlyFemales($query){
        return $query->where('gender',Constants::GENDER['female']);
    }
    
    public function scopeOnlyMales($query){
        return $query->where('gender',Constants::GENDER['male']);
    }

    public function scopeOnlySaudians($query){
        return $query->where('nationality_id',1);
    }

    public static function MaxLaborTimes($id_number){
         return ContractEmployee::where('id_number',$id_number)->count();
    }

    public static function MaxTotalPeriodTimes($id_number,$start,$end){
         return ContractEmployee::where('id_number',$id_number)->whereBetween('start_date',[$start,$end])
                                  ->whereBetween('end_date',[$start,$end])->count();

    }

    /**
     * @param $query
     *
     * @return mixed
     */
    public function scopeAllowedEmployeesType($query, $type)
    {
        //check taqawel Ishaar options
        $options = IshaarSetup::where('ishaar_type_id', $type)->first();
        //return employee Type Scope 
        $query->where(function($query) use($options) {
            if ($options->labor_status_employed == 1 && $options->labor_status_visitor == 1) {
                return $query->employeedOrVisitor();
            } else {
                if ($options->labor_status_employed == 1) {
                    return $query->employeed();
                }
                if ($options->labor_status_visitor == 1) {
                    return $query->visitor();
                }
            }
        });
    }

    public function scopeAllowedEmployeesGender($query, $type)
    {
        //check taqawel Ishaar options
        $options = IshaarSetup::where('ishaar_type_id', $type)->first();
        //return employee Type Scope
        $query->where(function($query) use($options) {
            if ($options->labor_gender_male  == 1 && $options->labor_gender_female == 1) {
                return $query->anyGender();
            } else {
                if ($options->labor_gender_male  == 1) {
                    return $query->onlyMales();
                }
                if ($options->labor_gender_female == 1) {
                    return $query->onlyFemales();
                }
            }
        });
    }

}
