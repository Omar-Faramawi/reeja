<?php

namespace Tamkeen\Ajeer\Models;

use Illuminate\Database\Eloquent\Model;
use Tamkeen\Ajeer\Models\IshaarIssueGovernPerm;

class IshaarIssuePermissions extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "ishaar_issue_permission";
    
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function estPermissions()
    {
        return $this->hasMany(IshaarIssueEstPerm::class, "ishaar_issue_permission_id");
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function govPermissions()
    {
        return $this->hasMany(IshaarIssueGovernPerm::class, "ishaar_issue_permission_id");
    }
    
}
