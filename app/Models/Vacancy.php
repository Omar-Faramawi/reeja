<?php

namespace Tamkeen\Ajeer\Models;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\SoftDeletes;
use Tamkeen\Ajeer\Utilities\Constants;

class Vacancy extends BaseModel
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'vacancies';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'benf_type',
        'benf_id',
        'job_id',
        'salary',
        'hide_salary',
        'nationality_id',
        'gender',
        'religion',
        'no_of_vacancies',
        'region_id',
        'job_type',
        'work_start_date',
        'work_end_date',
        'status',
        'rejection_reason',
        'created_by',
        'updated_by',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['vacancy_name', 'gender_name', 'owner_name', 'job_type_text', 'religion_name'];


    /**
     * get the related job
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function job()
    {
        return $this->belongsTo(Job::class, 'job_id');
    }


    /**
     * get related region
     *
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function region()
    {
        return $this->belongsTo(Region::class, 'region_id');
    }

    /**
     * @return array
     */
    public function getReligionNameAttribute()
    {
        return Constants::RELIGIONS($this->religion);
    }

    /**
     * @return array
     */
    public function getGenderNameAttribute()
    {
        return Constants::GENDER($this->gender);
    }

    /**
     * Nationality for the current vacancy
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function nationality()
    {
        return $this->belongsTo(Nationality::class, 'nationality_id');
    }


    /**
     * Get the Locations for the vacancy.
     * @return VacancyLocations Model
     */
    public function locations()
    {
        return $this->hasMany(VacancyLocations::class, 'vacancies_id');
    }

    /**
     * @param $query
     *
     * @return mixed
     */
    public function scopeByMe($query)
    {
        if (session()->get('selected_establishment')) {
            $query = $query->where('benf_id', session()->get('selected_establishment.id'));
        } elseif (session()->get('government')) {
            $query = $query->where('benf_id', session()->get('government.id'));
        } else {
            $query = $query->where('benf_id', auth()->user()->id_no);
        }

        return $query->where('benf_type', \Auth::user()->user_type_id);
    }

    /**
     * @param $query
     *
     * @return mixed
     */
    public function scopeByOthers($query)
    {
        if (session()->get('selected_establishment')) {
            $benfId = session()->get('selected_establishment.id');
        } elseif (session()->get('government')) {
            $benfId = session()->get('government.id');
        } else {
            $benfId = auth()->user()->id_no;
        }
        $query->whereRaw('(benf_id != '.$benfId.' and benf_type = '.\Auth::user()->user_type_id.')');
        $query->orWhereRaw('(benf_id = '.$benfId.' and benf_type != '.\Auth::user()->user_type_id.')');
        $query->orWhereRaw('(benf_id != '.$benfId.' and benf_type != '.\Auth::user()->user_type_id.')');
        return $query;
    }

    /**
     * @param $query
     *
     * @return mixed
     */
    public function scopeNotSeasonal($query)
    {
        return $query->where('region_id', '!=', 1);
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
     * @param $query
     *
     * @return mixed
     */
    public function scopeActive($query)
    {
        return $query->where('status', '1');
    }

    /**
     * @param $query
     * @param $type
     * @param $id
     *
     * @return mixed
     */
    public function scopeByName($query, $type, $id)
    {
        return static::getName($type, $id);
    }


    /**
     * @param $type
     * @param $id
     *
     * @return mixed
     */
    public static function getName($type, $id)
    {
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
     * @return mixed
     *
     * Get vacancy name
     */
    public function getVacancyNameAttribute()
    {
        return static::getName($this->attributes['benf_type'], $this->attributes['benf_id']);
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
     * @param $query
     * @param $type
     * @param $name
     *
     * @return mixed
     */
    public function scopeByBenfName($query, $type, $name)
    {
        try {
            switch ($type) {
                case 0:
                    return Individual::whereHas('labor', function ($q) use ($name) {
                        $q->where('name', 'LIKE', '%' . $name . '%');
                    })->get();
                case 1:
                    return Establishment::where('name', 'LIKE', '%' . $name . '%')->get();
                case 2:
                    return Government::where('name', 'LIKE', '%' . $name . '%')->get();
            }
        } catch (ModelNotFoundException $e) {
            return false;
        }
    }

    /**
     * @return mixed
     */
    public function withBenf()
    {
        try {
            switch ($this->benf_type) {
                case 4:
                    $benf = IndividualLabor::where(['indviduals_id_number' => $this->benf_id])->first();
                    $benf->vacancy = $this;

                    return $benf;
                case 3:
                    $benf = Establishment::find($this->benf_id)->first();
                    $benf->vacancy = $this;

                    return $benf;
                case 2:
                    $benf = Government::find($this->benf_id)->first();
                    $benf->vacancy = $this;

                    return $benf;
            }
        } catch (ModelNotFoundException $e) {
            return false;
        }
    }

    /**
     * @return string
     */
    public function getOwnerNameAttribute()
    {
        try {
            switch ($this->benf_type) {
                case 4:
                    return Individual::findOrFail($this->benf_id)->name;
                case 3:
                    return Establishment::findOrFail($this->benf_id)->name;
                case 2:
                    return Government::findOrFail($this->benf_id)->name;
                default:
                    return trans('labels.empty_record');
            }
        } catch (ModelNotFoundException $e) {
            return trans('labels.not_found');
        }
    }

    /**
     * @return mixed
     */
    public function getJobTypeTextAttribute()
    {
        return trans('labor_market.job_type.' . $this->job_type);
    }

    /**
     * @param $query
     * @param $userType
     *
     * @return mixed
     */
    public function scopeByType($query, $userType)
    {
        switch ($userType) {
            case 2:
                $benf_type = 2;
                break;
            case 3:
                $benf_type = 1;
                break;
            case 4 or 5 :
                $benf_type = 0;
                break;
        }

        return $query->where("benf_type", "=", $benf_type);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function establishment()
    {
        return $this->belongsTo(Establishment::class, 'benf_id');
    }

    /**
     * @param $column
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function government($column = "benf_id")
    {
        return $this->belongsTo(Government::class, $column);
    }

    /**
     * @param $column
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function individual($column = "benf_id")
    {
        return $this->belongsTo(Individual::class, $column);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function contract()
    {
        return $this->hasMany(Contract::class, "vacancy_id");
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function jobRequest()
    {
        return $this->hasMany(JobRequest::class, "vacancies_id");
    }

}
