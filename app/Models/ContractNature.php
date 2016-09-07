<?php

namespace Tamkeen\Ajeer\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContractNature extends BaseModel
{


    use SoftDeletes;

    /**
     * add table name
     */
    protected $table = 'contract_nature';

    /**
     * add fillable array
     */
    protected $fillable = [
        "name",
        'created_by',
        'updated_by'
    ];
    /**
     * add deleted_by to timestamps
     */
    protected $dates = ['deleted_at'];


    /**
     * Contract Nature Belongs to users table
     * forign key is created_by
     *
     */
    public function user()
    {
        return $this->belongsTo(User::class, "created_by");
    }

    /**
     * The markettaqawoulservices that have the same contract_nature_id
     *
     */
    public function marketTaqawoulServices(){
        return $this->hasMany(MarketTaqawoulServices::class,"contract_nature_id");
    }

    public function Contract()
    {
        return $this->hasOne(Contract::class, "contract_nature_id");
    }
}
