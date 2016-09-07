<?php

namespace Tamkeen\Ajeer\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GovernmentPermissionActivity extends BaseModel
{
    protected $guarded = ['id'];
    protected $table = 'gover_permission_activities';

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }

    public function contractbenf()
    {
        return $this->belongsTo(ContractBeneficial::class, "contract_benf_id");
    }
}
