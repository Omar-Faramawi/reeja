<?php

namespace Tamkeen\Ajeer\Models;

use Illuminate\Database\Eloquent\Model;

class IshaarIssueGovernPerm extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table   = "gover_ishaar_issue_permission";

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function activity()
    {
        return $this->hasOne(Activity::class, "id", "activity_id");
    }
}
