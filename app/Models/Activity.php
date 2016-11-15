<?php

namespace Tamkeen\Ajeer\Models;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Activity
 * @package Tamkeen\Ajeer\Models
 */
class Activity extends Model
{
    /**
     * @var string
     */
    protected $table = 'activities';

    /**
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function establishments()
    {
        return $this->hasMany(EstablishmentPermissionActivity::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function governments()
    {
        return $this->hasOne(GovernmentPermissionActivity::class);
    }
}
