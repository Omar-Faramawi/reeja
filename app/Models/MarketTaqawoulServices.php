<?php

namespace Tamkeen\Ajeer\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Tamkeen\Ajeer\Utilities\Constants;


/**
 * Class MarketTaqawoulServices
 * @package Tamkeen\Ajeer\Models
 */
class MarketTaqawoulServices extends BaseModel
{

    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'market_taqaual_services';

    const Provider = 1;

    const Beneficial = 2;

    protected $guarded = ['id'];

    /**
     * @var array
     */
    protected $dates = ['deleted_at'];


	/**
	 * @var array
	 */
	protected $appends = ['providername', 'responsible_email', "responsible_mobile"];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    public function contractNature()
    {
        return $this->belongsTo(ContractNature::class, "contract_nature_id");
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function serviceProviderBeneficial()
    {
        return $this->belongsTo(ServiceProviderBeneficial::class, 'service_prvdr_benf_id');
    }


    /**
     * @param $query
     *
     * @return mixed
     *
     * return the contracts related to the current user from the current session
     */
    public function scopeByMe($query)
    {
        if (session()->get('selected_establishment')) {
            $query = $query->where('service_id',
                session()->get('selected_establishment.id'));
        } elseif (session()->get('government')) {
            $query = $query->where('service_id',
                session()->get('government.id'));
        } else {
            $query = $query->where('service_id', \Auth::user()->id_no);
        }

        return $query->where('service_prvdr_benf_id', \Auth::user()->user_type_id);
    }


    /**
     * @param $query
     *
     * @return mixed
     *
     * return all providers services
     */
    public function scopeByProviders($query)
    {
        return $query->where('provider_or_benf', Constants::SERVICETYPES['provider']);
    }


    /**
     * @param $query
     *
     * @return mixed
     *
     * return all benf services
     */
    public function scopeByBenf($query)
    {
        return $query->where('provider_or_benf', Constants::SERVICETYPES['benf']);
    }

    public function getResponsibleEmailAttribute()
    {
        $typeIds = $this->serviceProviderBeneficial->id;

        switch ($typeIds) {
            case 4:
            case 5:
            case 2:
                return $this->provider->email;
            case 3:
                if (isset($this->provider->responsibles)) {
                    return $this->provider->responsibles[0]->responsible_email;
                } else {
                    return null;
                }
        }
    }

    public function getResponsibleMobileAttribute()
    {
        $typeIds = $this->serviceProviderBeneficial->id;
        switch ($typeIds) {
            case 4:
            case 5:
                return $this->provider->phone;
            case 2:
                return null;
            case 3:
                if (isset($this->provider->responsibles)) {
                    return $this->provider->responsibles[0]->responsible_phone;
                } else {
                    return null;
                }
        }
    }


    /**
     * @return mixed
     */
    public function getProvidernameAttribute()
    {
        try {
            return $this->provider->name;
        } catch (\ErrorException $e) {
            return trans('labels.not_found');
        }

        return $this->provider->name;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function provider()
    {
        switch ($this->serviceProviderBeneficial->id) {
            case 4:
            case 5:
                return $this->individual("service_id");
            case 3:
                return $this->establishment("service_id");
            case 2:
                return $this->government("service_id");
        }

    }

    /**
     * @param $column
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function government($column = "service_id")
    {
        return $this->belongsTo(Government::class, $column);
    }


    public function individual($column = "service_id")
    {
        return $this->belongsTo(Individual::class, $column);
    }

    /**
     * @param $column
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function establishment($column = "service_id")
    {
        return $this->belongsTo(Establishment::class, $column);
    }


    public function scopeActive($query)
    {
        return $query->where('status', '1');
    }

    public function scopeByOthers($query)
    {
        return $query->where('service_id', "!=", $this->getCurrentLoginId());
    }

    public function contracts()
    {
        return $this->hasMany(Contract::class, "market_taqaual_services_id");
    }
}
