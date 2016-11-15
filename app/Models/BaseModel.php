<?php

namespace Tamkeen\Ajeer\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Vinkla\Hashids\Facades\Hashids;
use Tamkeen\Ajeer\Models\EstablishmentPermissionActivity as EsActivity;
use Tamkeen\Ajeer\Models\ServiceUsersPermission as UserPermission;
use Tamkeen\Ajeer\Utilities\Constants;
use Tamkeen\Ajeer\Models\EstablishmentSize;

class BaseModel extends Model
{
    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        if ( ! auth()->check()) {
            return;
        }
        $user_id = auth()->id();

        //created_by & updated_by
        static::creating(function ($model) use ($user_id) {
            $model->created_by = $user_id;
            $model->updated_by = $user_id;
        });

        static::updating(function ($model) use ($user_id) {
            $model->updated_by = $user_id;
        });
    }

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['hashids'];

    /**
     * The hashids method converter
     *
     * @return encode model id
     */
    public function getHashidsAttribute()
    {
        return Hashids::encode($this->id);
    }

    /**
     * The return by hashid method.
     *
     * @param  string $query
     * @param  string $value
     * @param  boolean $notHash
     *
     * @return $query string
     */
    public function scopeById($query, $value, $notHash = false)
    {
        if ( ! $notHash) {
            $value = Hashids::decode($value);
        }

        return $query->where('id', $value);
    }


    /**
     * @return integer $currentId
     *
     * We need to have the current login uesr ID across all the models
     * so we get that through this method
     */
    public function getCurrentLoginId()
    {
        if (session()->has('selected_establishment')) {
            $currentUserId = session()->get('selected_establishment.id');
        } elseif (session()->get('government')) {
            $currentUserId = session()->get('government.id');
        } else {
            $currentUserId = \Auth::user()->id_no;
        }

        return (int)$currentUserId;
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
     * @return true if current Establishment
     *  Can Be Provider As Admin Settings
     */
    public static function estCanBeProvider()
    {
        $permission = UserPermission::where('contract_type_id',  Constants::CONTRACTTYPES['taqawel'])
                                    ->where('service_prvdr_benf_id', Constants::USERPERMISSIONTYPES['est'])
                                    ->first(['id']);
        if ($permission) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * @return true if current Establishment
     *  Can Be Benef For Another Establishment
     *  As Admin Settings
     */
    public static function estCanBeBenf()
    {
        $permission = UserPermission::where('contract_type_id',  Constants::CONTRACTTYPES['taqawel'])
                                    ->where('service_prvdr_benf_id', Constants::USERPERMISSIONTYPES['est'])
                                    ->first(['benf_est']);
        if ($permission) {
            return $permission->benf_est;
        } else {
            return FALSE;
        }
    }

    /**
     * @return true if current Individual
     *  Can Be Provider As Admin Settings
     */
    public static function indvCanBeProvider()
    {
        $permission = UserPermission::where('contract_type_id',  Constants::CONTRACTTYPES['taqawel'])
                                    ->where('service_prvdr_benf_id', Constants::USERPERMISSIONTYPES['indv'])
                                    ->first(['id']);
        if ($permission) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * @return true if current Individual
     *  Can Be Benef For Another Establishment
     *  As Admin Settings
     */
    public static function indvCanBeBenf()
    {
        $permission = UserPermission::where('contract_type_id',  Constants::CONTRACTTYPES['taqawel'])
                                    ->where('service_prvdr_benf_id', Constants::USERPERMISSIONTYPES['indv'])
                                    ->first(['benf_indv']);
        if ($permission) {
            return $permission->benf_indv;
        } else {
            return FALSE;
        }
    }

    /**
     * @return all Provider Establishment permitted activities
     *
     */
    public static function estProviderPermittedActivities()
    {
       return EsActivity::where('service_users_permission_id',Constants::USERPERMISSIONTYPES['est'])
                                  ->where('provider',1)
                                  ->pluck('activity_id')->toArray();

    }

    /**
     * @return all Benf Establishment permitted activities
     *
     */
    public static function estBenfPermittedActivities()
    {
        return EsActivity::where('service_users_permission_id', Constants::USERPERMISSIONTYPES['est'])
                                  ->where('benf',1)
                                  ->pluck('activity_id')->toArray();

    }

    /**
     * @param activity_id
     * @return The Percentage of Loan percentage for Activity
     *
     */
    public static function estLoanPercentage($activity_id)
    {
        $activities = EsActivity::where('activity_id',$activity_id)->first(['loan_pct']);
        if ($activities) {
            return $activities->loan_pct;
        } else {
            return 0;
        }
    }
    
    /**
     * @param activity_id
     * @return The Percentage of Borrow percentage for Activity
     *
     */
    public static function estBorrowPercentage($activity_id)
    {
        $activities = EsActivity::where('activity_id',$activity_id)->first(['borrow_pct']);
        if ($activities) {
            return $activities->borrow_pct;
        } else {
            return 0;
        }
    }

    /**
     * @param establishment id
     * @return count of current laborers for temp work HireLabor
     */
    public static function estLaborerCount($provider_id){
        return ContractEmployee::whereHas('contract',function ($cont) use($provider_id) {
                        $cont->byMe()->approved()->hireLabor()->where('provider_id',$provider_id);
                    })->count();
    }

    /**
     * @param establishment size id
     * @return The Percentage of Loan percentage for establishment
     *
     */
    public static function estSizeLoanPercentage($size_id)
    {
        $size = EstablishmentSize::find($size_id);
        if ($size) {
            return $size->pct_hire_labor_tmp_work;
        } else {
            return 0;
        }
    }
}