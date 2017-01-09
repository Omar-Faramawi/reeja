<?php

namespace Tamkeen\Ajeer\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\SoftDeletes;
use Tamkeen\Ajeer\Utilities\Constants;

class Contract extends BaseModel
{

    use SoftDeletes;
    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * add deleted_by to timestamps
     */
    protected $dates = ['deleted_at'];

    /**
     * @var array
     */
    protected $appends = [
        'hashids',
        'providername',
        'benf_name',
        'responsible_email',
        'provider_responsible_email',
        'responsible_mobile',
        'status_name',
        'status_alias',
        'cancelled_employees',
        'cancelled_employees_by_others',
        'expired'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     *
     * belong to one contract type
     */
    public function contractTypes()
    {
        return $this->belongsTo(ContractType::class, 'contract_type_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     *
     * Contract related to a added vacancy
     */
    public function vacancy()
    {
        return $this->belongsTo(Vacancy::class, 'vacancy_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     *
     * Has many contract locations
     */
    public function contractLocations()
    {
        return $this->hasMany(ContractLocation::class, 'contract_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     *
     * Has many contract Edits
     */
    public function contractEdits()
    {
        return $this->hasMany(ContractEdit::class, 'contract_id');
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
            $query = $query->where('provider_id',
                session()->get('selected_establishment.id'));
        } elseif (session()->get('government')) {
            $query = $query->where('provider_id',
                session()->get('government.id'));
        } else {
            $query = $query->where('provider_id', \Auth::user()->id_no);
        }

        return $query->where('provider_type', \Auth::user()->user_type_id);
    }


    /**
     * @param $query
     * @param $contractType
     *
     * @return mixed
     *
     * Get contract type
     */
    public function scopeGetByContractType($query, $contractType)
    {
        return $query->where('contract_type_id', $contractType);
    }

    /**
     * @param $query
     *
     * @return mixed
     *
     * return the contracts pending
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * return only status requested
     *
     * @param $query
     */
    public function scopeRequested($query)
    {
        return $query->where('status', 'requested');
    }

    /**
     *
     * Where contract has reference
     *
     * @param $query
     * @param $marketServices
     *
     * @return mixed
     */
    public function scopeHasReference($query, $marketServices)
    {
        return $query->where('contract_nature_id', $marketServices->contract_nature_id);
    }


    /**
     * @param $query
     *
     * @return mixed
     *
     * return the contracts approved
     *
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * @param $type
     * @param $id
     *
     * @return mixed
     */
    public static function getName($type, $id)
    {
        try {
            switch ($type) {
                case 4:
                case 5:
                    return Individual::findOrFail($id)->name;
                case 2:
                    return Government::findOrFail($id)->name;
                case 3:
                    return Establishment::findOrFail($id)->name;
            }
        } catch (ModelNotFoundException $e) {
            return trans('labels.not_found');
        }
    }


    /**
     * @param $type
     * @param $id
     *
     * @return mixed
     */
    public static function getRelated($type, $id)
    {
        try {
            switch ($type) {
                case 4:
                case 5:
                    return Individual::findOrFail($id);
                case 2:
                    return Government::findOrFail($id);
                case 3:
                    return Establishment::findOrFail($id);
            }
        } catch (ModelNotFoundException $e) {
            return trans('labels.not_found');
        }
    }

    /**
     * @return mixed
     */
    public function getProvidernameAttribute()
    {
        return $this->provider->name;
    }

    /**
     * @return mixed
     *
     * Get the related benf_name
     */
    public function getBenfNameAttribute()
    {
        return $this->benef->name;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function provider()
    {

        switch ($this->provider_type) {
            case 4:
            case 5:

                return $this->individual("provider_id");
                break;
            case 3:
                return $this->establishment("provider_id");
                break;
            case 2:
                return $this->government("provider_id");
                break;
        }
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function benef()
    {
        switch ($this->benf_type) {
            case 4:
            case 5:
                return $this->individual("benf_id");
                break;
            case 3:
                return $this->establishment("benf_id");
                break;
            case 2:
                return $this->government("benf_id");
                break;
            default:
                return $this->establishment("benf_id");     // default
                break;
        }
    }

    /**
     * @param $column
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function government($column = "provider_id")
    {
        return $this->belongsTo(Government::class, $column);
    }

    /**
     * @param $column
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function individual($column = "provider_id")
    {
        return $this->belongsTo(Individual::class, $column);
    }

    /**
     * @param $column
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function establishment($column = "provider_id")
    {
        return $this->belongsTo(Establishment::class, $column);
    }

    /**
     * @param $column
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function benfGovernment($column = "benf_id")
    {
        return $this->belongsTo(Government::class, $column);
    }

    /**
     * @param $column
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function benfIndividual($column = "benf_id")
    {
        return $this->belongsTo(Individual::class, $column);
    }

    /**
     * @param $column
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function benfEstablishment($column = "benf_id")
    {
        return $this->belongsTo(Establishment::class, $column);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function hrPool()
    {
        //return $this->hasOne(HRPool::class, 'id_number', 'id');
        return $this->hasManyThrough(HRPool::class, ContractEmployee::class, 'contract_id', 'id_number', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function contractEmployee()
    {
        return $this->hasMany(ContractEmployee::class, "contract_id", "id");
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function jobRequest()
    {
        return $this->belongsTo(JobRequest::class);
    }

    /**
     * @param $query
     *
     * @return mixed
     */
    public function scopeToMe($query)
    {
        if (session()->get('selected_establishment')) {
            $query = $query->where('benf_id',
                session()->get('selected_establishment.id'));
        } elseif (session()->get('government')) {
            $query = $query->where('benf_id', session()->get('government.id'));
        } else {
            $query = $query->where('benf_id', auth()->user()->id_no);
        }

        return $query->where('benf_type', auth()->user()->user_type_id);
    }

    /**
     * @param $query
     *
     * @return mixed
     */
    public function scopeDirectEmp($query)
    {
        return $query->where('contract_type_id', Constants::CONTRACTTYPES['direct_emp']);
    }

    /**
     * @param $query
     *
     * @return mixed
     */
    public function scopeTaqawel($query)
    {
        return $query->where('contract_type_id', Constants::CONTRACTTYPES['taqawel']);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function employees()
    {
        return $this->hasMany(ContractEmployee::class, 'contract_id');
    }

    public function getCancelledEmployeesAttribute()
    {
        $emp_status = ($this->provider_id == auth()->user()->id_no && $this->provider_type == auth()->user()->user_type_id) ? 'benef_cancel' : 'provider_cancel';
        $employees = ContractEmployee::where([
            'contract_id' => $this->id,
            'status'      => $emp_status,
        ])->lists('id');
        $this->attributes['cancelled_employees'] = $employees;

        return count($employees) > 0 ? $employees : false;
    }

    public function getCancelledEmployeesByOthersAttribute()
    {
        $emp_status = ($this->provider_id == auth()->user()->id_no && $this->provider_type == auth()->user()->user_type_id) ? 'provider_cancel' : 'benef_cancel';
        $employees = ContractEmployee::where([
            'contract_id' => $this->id,
            'status'      => $emp_status,
        ])->lists('id');
        $this->attributes['cancelled_employees'] = $employees;

        return count($employees) > 0 ? $employees : false;
    }

    /**
     * @param $query
     * @param $type
     * @param $id
     *
     * @return mixed
     */
    public function scopeByName($query, $type, $id)
    {
        try {
            switch ($type) {
                case 4:
                    return Individual::findOrFail($id)->ownership_name;
                case 3:
                    return Establishment::findOrFail($id)->name;
                case 2:
                    return Government::findOrFail($id)->name;
            }
        } catch (ModelNotFoundException $e) {
            return trans('labels.not_found');
        }
    }

    /**
     * @param $query
     * @param $type
     * @param $id
     *
     * @return mixed
     */
    public function scopeByNo($query, $type, $id)
    {
        try {
            switch ($type) {
                case 4:
                    return Individual::findOrFail($id)->nid;
                case 3:
                    return Establishment::findOrFail($id)->sequence_no;
                case 2:
                    return Government::findOrFail($id)->id;
            }
        } catch (ModelNotFoundException $e) {
            return trans('labels.not_found');
        }
    }

    /**
     * @param $query
     */
    public function scopeHireLabor($query)
    {
        $query->where("contract_type_id", Constants::CONTRACTTYPES['hire_labor']);
    }

    /**
     * @param $query
     * @param $status
     *
     * @return mixed
     *
     * Scope Status
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * @param $query
     *
     * @return mixed
     */
    public function scopeReceivedRequest($query)
    {
        return $query->where('status', 'requested');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function contractType()
    {
        return $this->belongsTo(ContractType::class, "contract_type_id");
    }

    /**
     * @param $query
     */
    public function scopeDirectEmployee($query)
    {
        $query->where("contract_type_id", Constants::CONTRACTTYPES['direct_emp']);
    }

    /**
     * @return mixed
     */
    public function scopePendinOwnerShip($query)
    {
        return $query->where("status", "pending_ownership");
    }

    /**
     * @param $query
     * @param $hashedid
     *
     * @return mixed
     */
    public function scopeMyOwnership($query, $hashedid)
    {
        $ownership_id = !empty(session('selected_establishment.id_number')) ? session('selected_establishment.id_number')
            : session('user.national_id');

        return $query->where("ownership_hashed", $hashedid)->where("ownership_id",
            $ownership_id);
    }

    public function getStatusNameAttribute()
    {
        return trans('contracts.statuses.' . $this->status);
    }


    public function getResponsibleEmailAttribute()
    {
        switch ($this->benf_type) {
            case 4:
            case 5:
            case 2:
                return $this->benef->email;
            case 3:
                if (isset($this->benef->responsibles)) {
                    return $this->benef->responsibles[0]->responsible_email;
                } else {
                    return null;
                }
        }
    }

    public function getProviderResponsibleEmailAttribute()
    {
        switch ($this->provider_type) {
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
        switch ($this->benf_type) {
            case 4:
            case 5:
                return $this->benef->phone;
            case 2:
                return null;
            case 3:
                if (count($this->benef->responsibles) > 0) {
                    return $this->benef->responsibles[0]->responsible_phone;
                } else {
                    return null;
                }
        }
    }

    public function getStatusAliasAttribute()
    {
        $prvd_benf = request()->route()->parameter('prvd_benf');
        $prvd_benf_str = $prvd_benf == 1 ? 'benef' : 'provider';
        if ($prvd_benf == 1) {
            $prvd_benf_others = 2;
            $prvd_benf_str_others = 'provider';
        } else {
            $prvd_benf_others = 1;
            $prvd_benf_str_others = 'benef';
        }
        if ($this->status == 'approved') {
            if (count($this->employees) == 0) {
                return trans('contracts.status_alias.' . $prvd_benf . '.' . $this->status . '_without_ishaar');
            } elseif ($this->cancelled_employees) {
                return trans('contracts.status_alias.' . $prvd_benf . '.' . $prvd_benf_str . '_cancel_employee');
            } elseif ($this->cancelled_employees_by_others) {
                return trans('contracts.status_alias.' . $prvd_benf_others . '.' . $prvd_benf_str_others . '_cancel_employee');
            } else {
                if (date('Y-m-d') > $this->end_date && count($this->employees) > 0) {
                    return trans('contracts.status_alias.' . $prvd_benf . '.' . $this->status . '_finished');
                } else {
                    return trans('contracts.status_alias.' . $prvd_benf . '.' . $this->status);
                }
            }
        } else {
            // Special case - inverted alias
            if (in_array($this->provider_type, [Constants::USERTYPES['saudi'], Constants::USERTYPES['job_seeker']])) {
                return trans('contracts.status_alias.' . $prvd_benf_others . '.' . $this->status);
            }

            return trans('contracts.status_alias.' . $prvd_benf . '.' . $this->status);
        }
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function Invoices()
    {
        return $this->hasManyThrough(Invoice::class, ContractEmployee::class,
            "contracts_id", "invoices_id", "id");
    }

    /**
     * Belongs to contract nature id
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function contractNature()
    {
        return $this->belongsTo(ContractNature::class, 'contract_nature_id');
    }

    public function marketTaqawoulServices()
    {
        return $this->belongsTo(MarketTaqawoulServices::class, "market_taqaual_services_id");
    }

    /**
     * @param $query
     *
     * @return mixed
     */
    public function scopeEditable($query)
    {
        return $query->whereIn('status', ['pending', 'requested', 'approved']);
    }

    /**
     * @param $query
     *
     * @return mixed
     */
    public function scopeByStatus($query, $status)
    {
        return $query->whereIn('status', $status);
    }

    /**
     * @param $query
     *
     * @return mixed
     */
    public function scopeEstablishmentProvider($query)
    {
        return $query->where(['provider_type' => Constants::USERTYPES['est']]);
    }

    /**
     * @param $query
     *
     * @return mixed
     */
    public function scopeEstablishmentProviderWithActivity($query, $activity_id)
    {
        return $query->where(['provider_type' => Constants::USERTYPES['est']])->whereHas('establishment',
            function ($q) use ($activity_id) {
                $q->where('activity_id', $activity_id);
            });
    }

    /**
     * @param $query
     *
     * @return mixed
     */
    public function scopeEstablishmentBeneficialWithActivity($query, $activity_id)
    {
        return $query->establishmentBeneficial()->whereHas('benfEstablishment',
            function ($q) use ($activity_id) {
                $q->whereActivityId($activity_id);
            });
    }

    /**
     * @param $query
     *
     * @return mixed
     */
    public function scopeEstablishmentBeneficial($query)
    {
        return $query->where(['benf_type' => Constants::USERTYPES['est']]);
    }

    /**
     * Checks whether this contract is by me or to me
     */
    public function byMeOrToMe()
    {
        if ($this->provider_id == $this->getCurrentLoginId() && $this->provider_type == auth()->user()->user_type_id) {
            return array_search('benef', Constants::PRVD_BENF_SHORTCUT);
        } else {
            return array_search('provider', Constants::PRVD_BENF_SHORTCUT);
        }
    }


    /**
     * Check if contract is expired contract status
     *
     * @return bool
     */
    public function getExpiredAttribute()
    {
        $contractEndDate = Carbon::parse($this->end_date);
        $today           = Carbon::now();

        if($this->status  == 'approved' && $contractEndDate->lt($today)) {
            return true;
        }

        return false;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     *
     * Contract related to a reason
     */
    public function reason()
    {
        return $this->belongsTo(Reason::class, 'reason_id');
    }
}