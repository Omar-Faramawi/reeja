<?php

namespace Tamkeen\Ajeer\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceUsersPermission extends BaseModel
{
    use SoftDeletes;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'service_users_permission';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    public function contractType()
    {
        return $this->belongsTo(ContractType::class, "contract_type_id");
    }

    public function estPermActivities()
    {
        return $this->hasMany(EstablishmentPermissionActivity::class);
    }

    public function goverActivities()
    {
        return $this->hasMany(GovernmentPermissionActivity::class);
    }

    public function serviceProviderBeneficial()
    {
        return $this->belongsTo(ServiceProviderBeneficial::class, 'service_prvdr_benf_id');
    }
}
