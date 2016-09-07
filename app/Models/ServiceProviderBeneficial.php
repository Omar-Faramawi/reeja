<?php

namespace Tamkeen\Ajeer\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceProviderBeneficial extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'service_prvdr_benf';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    protected $appends = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function marketTaqawoulServices()
    {
        return $this->hasMany(MarketTaqawoulServices::class, "service_prvdr_benf_id");
    }

}
