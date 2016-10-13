<?php

namespace Tamkeen\Ajeer\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContractType extends BaseModel
{


    use SoftDeletes;

    /**
     * add table name
     */
    protected $table = 'contract_types';

    /**
     * add fillable array
     */
    protected $fillable = [
        "name",
        'created_by',
        'updated_by',
    ];
    /**
     * add deleted_by to timestamps
     */
    protected $dates = ['deleted_at'];


    /**
     * Contract Types Belongs to users table
     * forign key is created_by
     *
     */
    public function user()
    {
        return $this->belongsTo(User::class, "created_by");
    }

    /**
     * The Contract Setup that have the same contract_type_id
     *
     */
    public function setup()
    {
        return $this->hasOne(ContractSetup::class, "contract_type_id");
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     * 
     * has many contracts 
     */
    public function contracts()
    {
        return $this->hasMany(Contract::class, 'contract_type_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function permissionServiceEnviroment()
    {
        return $this->hasMany(PermissionServiceEnviroment::class, 'contract_type_id');
    }
}
