<?php

namespace Tamkeen\Ajeer\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bundle extends BaseModel
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'bundles';

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
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'min_of_num_ishaar',
        'max_of_num_ishaar',
        'monthly_amount',
        'status',
    ];

    /**
     * @param $query
     *
     * @return mixed
     */
    public function scopePaid($query)
    {
        return $query->where('monthly_amount', '>', 0);
    }

    /**
     * @param $query
     *
     * @return mixed
     */
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function scopeTrail($query)
    {
        return $query->where('monthly_amount', 0);
    }
}
