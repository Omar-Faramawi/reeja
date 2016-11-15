<?php

namespace Tamkeen\Ajeer\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Tamkeen\Ajeer\Utilities\Constants;

/**
 * Class Invoice
 *
 * @property int    $bill_number
 * @property int    $account_number
 * @property Carbon $issue_date
 * @property Carbon $expiry_date
 * @property Carbon $amount
 * @property Carbon $status
 * @method static $this pending()
 * @method static $this expired()
 */
class Invoice extends BaseModel
{
    const STATUS_PENDING = 0;
    const STATUS_PAID    = 1;
    const STATUS_EXPIRED = 2;
    
    /**
     * Date attributes.
     *
     * @var array
     */
    public $dates = [
        'issue_date',
        'expiry_date',
    ];
    
    /**
     * @var array
     */
    protected $casts = [
        'status' => 'int',
    ];
    
    /**
     * Fillable attributes.
     *
     * @var array
     */
    protected $fillable = [
        'contracts_id',
        'bill_number',
        'amount',
        'account_no',
        'benf_name',
        'description',
        'issue_date',
        'expiry_date',
        'paid_date',
        'status',
        'provider_type',
        'provider_id',
    ];

    /**
     * Appends attributes.
     *
     * @var array
     */
    protected $appends = [
        'status_name',
        'trans_invoice_type',
    ];

    /**
     * @return bool
     */
    public function isPaid()
    {
        return $this->status == self::STATUS_PAID;
    }
    
    /**
     * @return bool
     */
    public function isPending()
    {
        return $this->status == self::STATUS_PENDING;
    }
    
    /**
     * @return bool
     */
    public function isExpired()
    {
        return $this->status == self::STATUS_EXPIRED;
    }
    
    
    /**
     * Expire a bill
     */
    public function expire()
    {
        $this->update(['status' => self::STATUS_EXPIRED]);
    }
    
    
    public function scopePaid(Builder $query)
    {
        return $query->where('status', static::STATUS_PAID);
    }
    
    public function scopePending(Builder $query)
    {
        return $query->where('status', static::STATUS_PENDING);
    }
    
    public function scopeExpired(Builder $query)
    {
        return $query->where('expiry_date', '<', Carbon::now());
    }
    
    public function scopeOfAccount(Builder $query, $account)
    {
        return $query->where('account_no', $account);
    }
    
    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contracts_id');
    }
    
    public function scopeByMe($query)
    {
        return $query->where("provider_type", Auth::user()->user_type_id)
            ->where("provider_id", getCurrentUserNameAndId()[0]);
    }
    
    public function invoiceBundles()
    {
        return $this->hasMany(InvoiceBundle::class, "invoice_id");
    }
    
    /**
     * Set bill and its notices as paid
     */
    public function setPaid()
    {
        $this->update([
            'status'    => self::STATUS_PAID,
            'paid_date' => Carbon::now(),
        ]);
    }

    public function scopeNotExpired(Builder $query)
    {
        return $query->where('expiry_date', '>', Carbon::now());
    }

    /**
     * Get the comments for the blog post.
     */
    public function certificates()
    {
        return $this->hasMany(ContractCertificate::class, "invoice_id");
    }

    public function getStatusNameAttribute()
    {
        if (is_null($this->status)) {
            return '';
        }
        
        $expireDate = Carbon::createFromTimestamp(strtotime($this->expiry_date));
        if ($this->status == '0' && $expireDate <= Carbon::today()) {
            $this->status = '2';
        }

        return Constants::invoiceStatues(['file' => 'invoices.statuses'], $this->status);
    }
    public function getTransInvoiceTypeAttribute()
    {
        if (is_null($this->invoice_type)) {
            return '';
        }

        return Constants::invoiceTypes(['file' => 'invoices.types'], $this->invoice_type);
    }
}