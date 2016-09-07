<?php

namespace Tamkeen\Ajeer\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Region.
 */
class Region extends BaseModel
{

    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'regions';

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
     * Regions belongs to many ishaar setups
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function ishaar_setups()
    {
        return $this->belongsToMany(IshaarSetup::class, 'ishaar_region', 'regions_id',
            'ishaar_setup_id')->withTimestamps();
    }


    /**
     * Vacancy related to one region ( has one ) 
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function vacancy()
    {
        return $this->hasOne(Region::class, 'region_id');
    }

    /**
     * Contract location has many
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function contractLocation()
    {
        return $this->hasMany(ContractLocation::class, 'region_id');
    }

    /**
     * @param $value | string
     *
     * @return string ( translation string or value from database )
     *
     * Translate region name if there is a translation key set
     */
    public function getNameAttribute($value)
    {
        $langExists = trans()->has("ishaar_setup.attributes.{$value}");

        if ($langExists) {
            return trans("ishaar_setup.attributes.{$value}");
        }

        return $value;
    }


}
