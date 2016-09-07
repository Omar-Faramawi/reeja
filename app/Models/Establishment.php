<?php

namespace Tamkeen\Ajeer\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Tamkeen\Ajeer\Utilities\Constants;
use \Tamkeen\Platform\MOL\Model\Establishment as MOLEstablishment;

class Establishment extends BaseModel
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'establishments';

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


    protected $appends = ['status_name'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'labour_office_no',
        'sequence_no',
        'id_number',
        'email',
        'name',
        'est_activity',
        'est-size',
        'est_nitaq',
        'district',
        'city',
        'region',
        'wasel_address',
        'local_liecense_no',
        'phone',
        'parent_id',
        'status',
        'reason_id',
        'rejection_reason',
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

    /**
     * @param MOLEstablishment $est
     *
     * @return Establishment
     */
    public static function findEstablishmentOrCreate(MOLEstablishment $est, $owner_id)
    {
        $establishment = Establishment::where('labour_office_no', $est->number()->laborOfficeId())
            ->where('sequence_no', $est->number()->sequenceNumber())->first();

        if (!$establishment) {
            $establishment = new Establishment();
            $establishment->name = $est->name();
            $establishment->id_number = $owner_id;
            $establishment->FK_establishment_id = $est->number()->toString();
            $establishment->labour_office_no = $est->number()->laborOfficeId();
            $establishment->sequence_no = $est->number()->sequenceNumber();
            $establishment->est_activity = $est->economicActivity()->mainEconomicActivity();
            $establishment->status = $est->status();
            $establishment->save();
        }

        return $establishment;
    }

    /* Abdelrazek Work */
    public function benfContracts()
    {
        return $this->hasManyThrough(Establishment::class, Contract::class, "benf_id", "id", "id");
    }

    public function contractProvider()
    {
        return $this->hasManyThrough(Establishment::class, Contract::class, "provider_id", "id", "id");
    }

    public function contract()
    {
        return $this->hasMany(Contract::class, "provider_id");
    }

    /* End Of Abdelrazek Work */

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function responsibles()
    {
        return $this->hasMany(Responsible::class, 'establishments_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     *
     * Establishment has many contracts locations
     */
    public function contractLocations()
    {
        return $this->hasMany(ContractLocation::class, "branch_id");
    }

    /**
     * Get the string representing the establishment status
     */
    public function getStatusNameAttribute()
    {
        return !is_null($this->status) ? Constants::estStatus($this->status, ['file' => 'est_profile']) : '';
    }
}
