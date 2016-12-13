<?php

namespace Tamkeen\Ajeer\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Tamkeen\Ajeer\Utilities\Constants;

class ContractEmployee extends BaseModel
{

    use SoftDeletes;


    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * add table name
     */
    protected $table = 'contract_employees';


    /**
     * add deleted_by to timestamps
     */
    protected $dates = ['deleted_at'];

    /**
     * @var array
     */
    protected $appends = ['translated_status','created_date_formatted'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contract_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function hrPool()
    {
        return $this->belongsTo(HRPool::class, 'id_number');
    }

    /**
     * Get the permission to cancel Ishaar.
     * @return mixed
     */
    public static function has_permission_cancelIshaar($id)
    {
        try {
            $ishaar = Self::findOrFail($id);
            if ($ishaar) {
                $auth = ContractSetup::where('contract_type_id', $ishaar->contract->contract_type_id)->first();
                if ($auth) {
                    if (session()->get('service_type') == Constants::SERVICETYPES['provider']) {
                        return $auth->benf_cancel_ishaar;
                    } else {

                        return $auth->provider_cancel_ishaar;
                    }

                }
            }
        } catch (ModelNotFoundException $e) {
            return trans('labels.not_found');
        }
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function contractEmployeeLocation()
    {
        return $this->hasMany(ContractEmployeeLocation::class, "employee_id");
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function Invoices()
    {
        return $this->hasMany(Invoice::class, 'invoices_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoices_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function ishaarSetup()
    {
        return $this->belongsTo(IshaarSetup::class, 'ishaar_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function invoiceBundle()
    {
        return $this->belongsTo(InvoiceBundle::class, 'bundle_id');
    }

    /**
     * @return mixed
     */
    public function getTranslatedStatusAttribute()
    {
        if ($this->status == Constants::CONTRACT_STATUSES['pending']) {
            if ($this->invoices_id) {
                $invoiceStatus = @$this->invoice->status;
                if ($invoiceStatus == '1') {
                    return trans('contracts.notice_invoice_statuses.paid');
                } elseif ($invoiceStatus == '0') {
                    return trans('contracts.notice_invoice_statuses.pending');
                } elseif ($invoiceStatus == '2') {
                    return trans('contracts.notice_invoice_statuses.cancelled');
                }
            } else {
                return trans('contracts.notice_invoice_statuses.draft');
            }
        } elseif ($this->status == Constants::CONTRACT_STATUSES['approved']) {
            return trans('contracts.notice_invoice_statuses.paid');
        }

        return Constants::contract_statuses($this->status, ['file' => 'contracts.statuses']);
    }

    public static function MaxIshaarsForBenf($benf_id, $benf_type)
    {
        return self::whereHas('contract', function ($cont) use ($benf_id, $benf_type) {
            $cont->approved()->taqawel()->where('benf_id', $benf_id)->where('benf_type', $benf_type);
        })->count();
    }

    public static function MaxEmployeeIshaarsForBenfInPeriod($benf_id, $benf_type, $id_number)
    {
        return self::whereHas('contract', function ($cont) use ($benf_id, $benf_type) {
            $cont->approved()->taqawel()->where('benf_id', $benf_id)->where('benf_type', $benf_type);
        })->where('id_number', $id_number)->max('end_date');
    }

    public static function MinEmployeeIshaarsForBenfInPeriod($benf_id, $benf_type, $id_number)
    {
        return self::whereHas('contract', function ($cont) use ($benf_id, $benf_type) {
            $cont->approved()->taqawel()->where('benf_id', $benf_id)->where('benf_type', $benf_type);
        })->where('id_number', $id_number)->min('start_date');
    }

    public static function MaxIshaarsForProvider($provider_id, $provider_type){
        return self::whereHas('contract',function ($cont) use($provider_id, $provider_type) {
            $cont->approved()->taqawel()->where('provider_id',$provider_id)->where('provider_type', $provider_type);
        })->count();
    }

    /**
     * @return mixed
     */
    public function scopeTaqawel($query)
    {
        return $query->whereHas('contract', function ($q) {
            $q->where('contract_type_id', Constants::CONTRACTTYPES['taqawel']);
        });
    }

    /**
     * @return mixed
     */
    public function scopeTempWork($query)
    {
        return $query->whereHas('contract', function ($q) {
            $q->whereIn('contract_type_id', [
                Constants::CONTRACTTYPES['direct_emp'],
                Constants::CONTRACTTYPES['hire_labor'],
            ])->whereHas('vacancy', function ($q2) {
                $q2->notSeasonal();
            });
        });
    }

    /**
     * @return mixed
     */
    public function scopeTempInHajj($query)
    {
        return $query->whereHas('contract', function ($q) {
            $q->whereIn('contract_type_id', [
                Constants::CONTRACTTYPES['direct_emp'],
                Constants::CONTRACTTYPES['hire_labor'],
            ])->whereHas('vacancy', function ($q2) {
                $q2->seasonal();
            });
        });
    }

    /**
     * @return mixed
     */
    public function scopeEstablishmentBeneficialWithActivity($query, $activity_id)
    {
        return $query->whereHas('contract', function ($q) use ($activity_id) {
            $q->establishmentBeneficial()->whereHas('benfEstablishment',
                function ($q1) use ($activity_id) {
                    $q1->whereActivityId($activity_id);
                });
        });
    }

    /**
     * @return mixed
     */
    public function scopeEstablishmentProviderWithActivity($query, $activity_id)
    {
        return $query->whereHas('contract', function ($q) use ($activity_id) {
            $q->establishmentBeneficial()->whereHas('establishment',
                function ($q1) use ($activity_id) {
                    $q1->whereActivityId($activity_id);
                });
        });
    }


    /**
     * @return mixed
     */
    public function scopeEstablishmentBeneficial($query)
    {
        return $query->whereHas('contract', function ($q) {
            $q->establishmentBeneficial();
        });
    }

    /**
     * @return mixed
     */
    public function scopeEstablishmentProvider($query)
    {
        return $query->whereHas('contract', function ($q) {
            $q->establishmentBeneficial();
        });
    }

    public function benfIdPattern()
    {
        $benf_id = $this->contract->benf_id;
        $benf_type = $this->contract->benf_type;

        return $benf_id . '_' . $benf_type . '_' . $this->id_number;
    }
    public function getCreatedDateFormattedAttribute()
    {
        if (is_null($this->created_at)) {
            return '';
        }

        return $this->created_at->format('Y-m-d');
    }
}
