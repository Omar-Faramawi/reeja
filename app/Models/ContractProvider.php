<?php

namespace Tamkeen\Ajeer\Models;

use Illuminate\Database\Eloquent\Model;

class ContractProvider extends BaseModel
{
    protected $table = 'contract_providers';

    protected $guarded = ['id'];

    public function provider()
    {
        return $this->hasMany(ServiceProviderBeneficial::class, "service_provider_benf_id");
    }
}
