<?php

namespace Tamkeen\Ajeer\Models;

use Illuminate\Database\Eloquent\Model;

class ContractEmployeeLocation extends BaseModel
{

    protected $table = "contract_employee_locations";

    /**
     * add deleted_by to timestamps
     */
    protected $dates = ['deleted_at'];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    protected $appends = [];

    public function contractEmployee()
    {
        return $this->belongsTo(ContractEmployee::class, "employee_id");
    }
}
