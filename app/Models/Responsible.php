<?php

namespace Tamkeen\Ajeer\Models;

use Illuminate\Database\Eloquent\Model;

class Responsible extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "est_responsibles";
    
    protected $guarded = [];
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function establishment()
    {
        return $this->belongsTo(Establishment::class, 'establishments_id');
    }
}
