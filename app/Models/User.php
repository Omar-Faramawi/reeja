<?php

namespace Tamkeen\Ajeer\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hashids;

class User extends BaseModel implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract
{
    use SoftDeletes, Authenticatable, Authorizable, CanResetPassword;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'id_no',
        'user_type_id',
        'national_id',
        'active',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function contractnatures()
    {
        return $this->hasMany(ContractNature::class, "created_by");
    }

    public function type()
    {
        return $this->belongsTo(UserTypes::class, 'user_type_id');
    }

    /**
     * @param       $idNumber
     * @param array $userData
     *
     * @return static
     */
    public static function findByIdNumberOrCreate($idNumber, array $userData = [])
    {
        $user = User::firstOrNew(['national_id' => $idNumber]);

        if (!$user->exists) {
            $user->national_id  = $idNumber;
            $user->name         = data_get($userData, 'name');
            $user->user_type_id = 3;
            $user->email        = data_get($userData, 'email');
            $user->save();
        }
        session(['auth.type' => 'establishments']);
        
        return $user;
    }

    public function individual()
    {
        return $this->hasOne(Individual::class, 'id', 'id_no');
    }

    /**
     * return the government for this user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function government()
    {
        return $this->belongsTo(Government::class, 'id_no');
    }

    /**
     * return the establishment of this user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function establishment()
    {
        return $this->belongsTo(Establishment::class, 'id_no');
    }

}
