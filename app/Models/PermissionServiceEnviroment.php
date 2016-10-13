<?php

namespace Tamkeen\Ajeer\Models;

use Illuminate\Database\Eloquent\Model;
use Tamkeen\Ajeer\Utilities\Constants;

/**
 * Class PermissionServiceEnviroment
 * @package Tamkeen\Ajeer\Models
 */
class PermissionServiceEnviroment extends BaseModel
{
    /**
     * @var string
     */
    protected $table = 'permission_service_environment';

    /**
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function contractType()
    {
        return $this->belongsTo(ContractType::class, 'contract_type_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function taqyeemTemplatePermission()
    {
        return $this->belongsTo(TaqyeemTemplatePermission::class, 'template_permission_id');
    }

    public function scopeTaqawel($query)
    {
        return $query->where('contract_type_id', Constants::CONTRACTTYPES['taqawel']);
    }

    public function scopeDirect($query)
    {
        return $query->where('contract_type_id', Constants::CONTRACTTYPES['direct_emp']);
    }

    public function scopeHire($query)
    {
        return $query->where('contract_type_id', Constants::CONTRACTTYPES['hire_labor']);
    }

}
