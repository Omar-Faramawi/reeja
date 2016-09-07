<?php

namespace Tamkeen\Ajeer\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bank extends BaseModel
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'banks';

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
        'name',
        'parent_bank_id',
        'created_by',
        'updated_by',
    ];

    /**
     * each bank might have multiple banks
     *
     *  @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
     public function childrenBank()
     {
       return $this->hasMany(static::class, 'parent_bank_id');
     }

     /**
      * each bank might have one parent bank
      *
      *  @return \Illuminate\Database\Eloquent\Relations\HasMany
      */
      public function parentBank()
      {
        return $this->belongsTo(static::class, 'parent_bank_id');
      }
}
