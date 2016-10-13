<?php

namespace Tamkeen\Ajeer\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class ContractCertificate extends BaseModel
{

    use SoftDeletes;


    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * add table name
     */
    protected $table = 'contract_certificate';


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
     * Contract Certificate belongs to Invoice
     */
    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }

    

   

}
