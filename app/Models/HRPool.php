<?php

namespace Tamkeen\Ajeer\Models;

use Carbon\Carbon;
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
    protected $appends = ['age', 'gender_name', 'religion_name', 'provider_name'];

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
        $H = intval($date->format("Y"));
        $G = $H + 622 - ($H / 33);

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
        $H = intval($date->format("Y"));
        $G = $H + 622 - ($H / 33);

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
     * @param $type
     * @param $id
     *
     * @return mixed
     */
    public function getProviderNameAttribute()
    {
        $type = $this->attributes['provider_type'];
        $id = $this->attributes['provider_id'];
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


    public function contractEmployee()
    {
        return $this->hasOne(HRPool::class, "id_number");
    }
}