<?php

namespace Tamkeen\Ajeer\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class ContractLocation extends BaseModel
{

    use SoftDeletes;


    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * add table name
     */
    protected $table = 'contract_locations';


    /**
     * add deleted_by to timestamps
     */
    protected $dates = ['deleted_at'];
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contract_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * 
     * Contract location belongs to establishment
     */
    public function establishment()
    {
        return $this->belongsTo(Establishment::class, 'branch_id');
    }

    /**
     * Belongs to region
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function region()
    {
        return $this->belongsTo(Region::class, 'region_id');
    }

}
