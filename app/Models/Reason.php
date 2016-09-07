<?php

namespace Tamkeen\Ajeer\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reason extends BaseModel
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'reasons';

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
        'reason',
        'parent_id',
        'status',
        'created_by',
        'updated_by',
    ];

    /**
     * each reason might have multiple reasons
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function childrenReason()
    {
        return $this->hasMany(static::class, 'parent_id');
    }

    /**
     * each reason might have one parent reason
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function parentReason()
    {
        return $this->belongsTo(static::class, 'parent_id');
    }

    /**
     * @param $query
     *
     * @return $query
     */
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    /**
     * reasons for taqawel cancel
     *
     * @param $query
     *
     * @return mixed
     */
    public function scopeForTaqawelCancel($query)
    {
        return $query->where('parent_id', 4);
    }
}
