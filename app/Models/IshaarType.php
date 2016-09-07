<?php

namespace Tamkeen\Ajeer\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class IshaarType.
 */
class IshaarType extends BaseModel
{
    
    use softDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ishaar_types';

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
     * ishaar types that have many ishaar setups
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function setups()
    {
        return $this->hasMany(IshaarSetup::class, 'ishaar_type_id');
    }

    public function getNameAttribute()
    {
        return isset(trans('ishaar_types.names')[$this->attributes['name']]) ? trans('ishaar_types.names.'.$this->attributes['name']) : $this->name;
    }
}
