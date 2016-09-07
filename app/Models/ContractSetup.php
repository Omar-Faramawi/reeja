<?php

namespace Tamkeen\Ajeer\Models;

use Illuminate\Database\Eloquent\Model;

class ContractSetup extends BaseModel
{
    protected $table = 'contract_setup';

    protected $guarded = ['id'];

    public function contractType()
    {
        return $this->belongsTo(ContractType::class, "contract_type_id");
    }
}
