<?php

namespace Tamkeen\Ajeer\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Tamkeen\Ajeer\Utilities\Constants;

class InvoiceBundle extends BaseModel
{

    use SoftDeletes;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'invoice_bundles';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * @var array
     */
    protected $appends = [
        'status_alias',
        'created_at_alias'
    ];

    /**
     * @param $query
     * @return mixed
     * To determine if current user account paid or free
     * first we check about having bundels
     * return the bundels related to the current user
     */
    public function scopeByMe($query)
    {
        $myid = getCurrentUserNameAndId()[0];
        $query = $query->where('provider_id', $myid);

        return $query->where('provider_type', \Auth::user()->user_type_id);
    }

    /**
     * @param $query
     * To determine if current user account paid or free
     * second we check about invoice status paid
     * @return the bundels have paid status
     */
    public function scopePaid($query)
    {
        return $query->where('status', Constants::INVOICE_STATUS['paid']);
    }


    /**
     * @param $query
     * To determine if current user account paid or free
     * final we check about invoice expiration date
     * @return the bundels have no expire date
     */
    public function scopeNotExpired($query)
    {
        return $query->where('expire_date', '>', Carbon::now());
    }

    public function scopeHasRemainingNotices($query)
    {
        return $query->where('num_remaining_notices', '>', 0);
    }


    public function scopeAllowedNotices($query)
    {
        return $query->sum('num_remaining_notices');
    }

    public static function bundelsDeduction($num)
    {
        $bundels = Self::byMe()->paid()->notExpired()->hasRemainingNotices()->first();
        $allowed_num = $bundels->num_remaining_notices;
        if ($num <= $bundels->num_remaining_notices) {
            $bundels->num_remaining_notices = $allowed_num - $num;
            $bundels->save();

            return $bundels->id;
        } else {
            $newnum = $num - $bundels->num_remaining_notices;
            $bundels->num_remaining_notices = 0;
            $bundels->save();

            return Self::bundelsDeduction($newnum);

        }

    }

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function invoice()
    {
        return $this->belongsTo(Invoice::class,"invoice_id");
    }

	/**
	 * invoice bundle belong to the bundle
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function bundle()
    {
		return $this->belongsTo(Bundle::class, "bundle_id");
    }

    /**
     * @return mixed
     */
    public function getStatusAliasAttribute()
    {
        if ($this->status == '0') {
            $invoiceStatus = @$this->invoice->status;
            if ($invoiceStatus == '1') {
                return trans('packagesubscribe.package_statuses.paid');
            } elseif ($invoiceStatus == '0') {
                return trans('packagesubscribe.package_statuses.pending');
            } elseif ($invoiceStatus == '2') {
                return trans('packagesubscribe.package_statuses.cancelled');
            }
        } elseif ($this->status == '1') {
            if ($this->num_remaining_notices < 1) {
                return trans('packagesubscribe.package_statuses.no_remaining_notices');
            }

            $expireDate = Carbon::createFromFormat('Y-m-d', $this->expire_date);
            if ($expireDate < Carbon::now()) {
                return trans('packagesubscribe.package_statuses.expired');
            }

            return trans('packagesubscribe.package_statuses.paid');
        }

        return trans('packagesubscribe.package_statuses.draft');
    }

    public function getCreatedAtAliasAttribute($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->format('Y-m-d');
    }
}