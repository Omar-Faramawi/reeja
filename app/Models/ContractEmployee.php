<?php

namespace Tamkeen\Ajeer\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

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
    protected $appends = ['translated_status'];


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
                $auth = ContractSetup::where('contract_type_id',$ishaar->contract->contract_type_id)->first();
                if($auth){
                    if(session()->get('service_type') == \Tamkeen\Ajeer\Utilities\Constants::SERVICETYPES['provider']){
                        return $auth->benf_cancel_ishaar;
                    }else{

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
        return \Tamkeen\Ajeer\Utilities\Constants::contract_statuses($this->status,['file' => 'contracts.statuses']);
    }

    public static function MaxIshaarsForBenf($benf_id){
        return self::whereHas('contract',function ($cont) use($benf_id) {
                        $cont->byMe()->approved()->taqawel()->where('benf_id',$benf_id);
                    })->count();
    }

    public static function MaxEmployeeIshaarsForBenfInPeriod($benf_id, $id_number){
        return self::whereHas('contract',function ($cont) use($benf_id) {
                        $cont->byMe()->approved()->taqawel()->where('benf_id',$benf_id);
                    })->where('id_number',$id_number)->max('end_date');
    }

    public static function MinEmployeeIshaarsForBenfInPeriod($benf_id, $id_number){
        return self::whereHas('contract',function ($cont) use($benf_id) {
                        $cont->byMe()->approved()->taqawel()->where('benf_id',$benf_id);
                    })->where('id_number',$id_number)->min('start_date');
    }

}