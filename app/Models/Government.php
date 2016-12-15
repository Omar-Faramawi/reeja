<?php

namespace Tamkeen\Ajeer\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Government extends BaseModel
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'governments';

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
        'email',
        'parent_id',
        'hajj',
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
        return $this->hasOne(User::class, 'id_no')->where('user_type_id',  \Tamkeen\Ajeer\Utilities\Constants::USERTYPES['gov']);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function responsibles()
    {
        return $this->hasMany(GovResponsible::class, 'government_id');
    }
}
