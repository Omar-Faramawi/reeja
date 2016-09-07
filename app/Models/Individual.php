<?php

namespace Tamkeen\Ajeer\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Individual extends BaseModel
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'indviduals';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

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
        'nid',
        'ownership_id',
        'ownership_name',
        'name',
        'phone',
        'gender',
        'religion',
        'email',
        'user_type_id',
        'created_by',
        'updated_by',
    ];

    /**
     * The user that belongs to this government
     *
     * @return User Model
     */
    public function users()
    {
        return $this->hasOne(User::class, 'id_no');
    }

    public function labor()
    {
        return $this->hasOne(IndividualLabor::class, 'indviduals_id_number');
    }
}
