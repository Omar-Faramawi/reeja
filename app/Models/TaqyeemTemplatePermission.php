<?php

namespace Tamkeen\Ajeer\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Temp Model For TaqyeemTemplatePermission
 * Using It for Rating Model Check Deletes
 * Class TaqyeemTemplatePermission
 * @package Tamkeen\Ajeer\Models
 */
class TaqyeemTemplatePermission extends BaseModel
{

    /**
     * @var string
     */
    protected $table = 'taqyeem_template_permission';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ratingModels()
    {
        return $this->belongsTo(RatingModels::class, "taqyeem_template_id");
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function specificUsers()
    {
        return $this->hasMany(PermissionSpecificUser::class, 'template_permission_id', 'id');
    }

    public function contractType()
    {
        return $this->belongsToMany(ContractType::class, 'permission_service_environment', 'template_permission_id',
            'contract_type_id')->withPivot([
            'provider',
            'benf'
        ]);
    }

    public function permissionServiceEnvironment()
    {
        return $this->hasMany(PermissionServiceEnviroment::class, 'template_permission_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function PermissionSpecificUsers()
    {
        return $this->hasMany(PermissionSpecificUsers::class, 'template_permission_id');
    }

    public function scopeToMembers($query)
    {
        return $query->where('taqyeem_type', '1');
    }
    
}