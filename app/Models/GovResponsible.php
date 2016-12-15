<?php

namespace Tamkeen\Ajeer\Models;

use Illuminate\Database\Eloquent\Model;

class GovResponsible extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "gov_responsibles";
    
    protected $guarded = [];
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function government()
    {
        return $this->belongsTo(Government::class, 'government_id');
    }
}
