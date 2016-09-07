<?php

namespace Tamkeen\Ajeer\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class SaudiPercentage
 * @package Tamkeen\Ajeer\Models
 */
class SaudiPercentage extends BaseModel
{

    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'saudi_percentages';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function contractType()
    {
        return $this->belongsTo(ContractType::class, 'contract_type_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function providerActivity()
    {
        return $this->belongsTo(EstablishmentPermissionActivity::class, 'provider_activity_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function benefitActivity()
    {
        return $this->belongsTo(EstablishmentPermissionActivity::class, 'benf_activity_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function providerSize()
    {
        return $this->belongsTo(Size::class, 'provider_size_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function benefitSize()
    {
        return $this->belongsTo(Size::class, 'benf_size_id');
    }


}
