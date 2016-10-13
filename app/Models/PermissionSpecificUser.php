<?php

namespace Tamkeen\Ajeer\Models;

use Illuminate\Database\Eloquent\Model;

class PermissionSpecificUser extends Model
{
    /**
     * @var string
     */
    protected $table = 'permission_specific_users';

    /**
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * @var bool
     */
    public $timestamps = false;


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function provider()
    {
        return $this->hasMany(ServiceProviderBeneficial::class, "service_provider_benf_id");
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function TaqyeemTemplatePermission()
    {
        return $this->belongsTo(TaqyeemTemplatePermission::class, 'template_permission_id', 'id');
    }
}
