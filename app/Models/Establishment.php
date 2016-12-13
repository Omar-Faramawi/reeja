<?php

namespace Tamkeen\Ajeer\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Tamkeen\Ajeer\Utilities\Constants;
use Tamkeen\Platform\MOL\Model\Establishments\Status as EstablishmentStatus;

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


    protected $appends = ['status_name', 'est_size_name'];

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
        'est_size',
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
        return $this->hasOne(User::class, 'id_no')->where('user_type_id',  Constants::USERTYPES['est']);
    }

    /**
     * @param $est
     * @param $owner_id
     *
     * @return Establishment
     */
    public static function findEstablishmentOrCreate($est, $owner_id)
    {
        $establishment = Establishment::where('labour_office_no', $est->labor_office_id)
            ->where('sequence_no', $est->sequence_number)->first();
        //check if establishment activity stored before in activities
        $activity = Activity::firstOrCreate(['name' => $est->economic_activity]);

        if (!$establishment) {
            $establishment = new Establishment();
            $establishment->name = $est->name;
            $establishment->labour_office_no = $est->labor_office_id;
            $establishment->sequence_no = $est->sequence_number;
            $establishment->id_number = $owner_id;
            $establishment->FK_establishment_id = $est->FK_establishment_id;
            $establishment->est_activity = $est->economic_activity;
            $establishment->est_size = $est->size_id;
            $establishment->est_nitaq = $est->nitaqat_color;
            $establishment->est_nitaq_old = $est->nitaqat_color;
            $establishment->district = $est->district;
            $establishment->city = $est->city;
            $establishment->region = $est->region;
            $establishment->wasel_address = $est->street . ' - ' . $est->region . ' - ' . $est->city;
            $establishment->local_liecense_no = $est->cr_number;
            $establishment->phone = $est->phone;
            $establishment->status = $est->status_id;
            $establishment->activity_id = $activity->id;
            $establishment->save();
        } else {
            $establishment->activity_id = $activity->id;
            $establishment->est_nitaq = $est->nitaqat_color;
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
        return $this->hasMany(Contract::class, "provider_id")->where('provider_type', Constants::USERTYPES['est']);
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

    /**
     * @param $establishment_data
     *
     * @return TRue or Suitable Error Message
     */
    public static function checkEstablishmentStatus($establishment_data)
    {
        if ($establishment_data->status_id == EstablishmentStatus::NON_EXISTENT) {
            if (!empty($establishment_data->note)) {
                return redirect()->back()->with('choose_est_message',
                    trans('establishment.est_NON_EXISTENT_note', ['note' => $establishment_data->note]));
            } else {
                return redirect()->back()->with('choose_est_message', trans('establishment.est_NON_EXISTENT'));
            }
        } elseif (empty($establishment_data->cr_number)) {
            return redirect()->back()->with('choose_est_message', trans('establishment.est_no_cr_number'));
        }

        $cr_end_date = Carbon::createFromTimestamp(strtotime($establishment_data->cr_end_date));
        if ($cr_end_date <= Carbon::today()) {
            return redirect()->back()->with('choose_est_message', trans('establishment.est_cr_expired'));
        }

        if ($establishment_data->wasel_status == 0) {
            return redirect()->back()->with('choose_est_message', trans('establishment.est_wasel_status_issue'));
        }

        $wasel_expiry_date = Carbon::createFromTimestamp(strtotime($establishment_data->wasel_expiry_date));
        if ($wasel_expiry_date < Carbon::today()) {
            return redirect()->back()->with('choose_est_message', trans('establishment.est_wasel_status_expired'));
        }
    }

    /**
     * Get Activity name
     */
    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }

    public function invoice()
    {
        return $this->hasMany(Invoice::class, 'provider_id')->where('provider_type', Constants::USERTYPES['est']);
    }

    public function estSize()
    {
        return $this->belongsTo(EstablishmentSize::class, 'est_size');
    }

    public function getEstSizeNameAttribute()
    {
        return $this->estSize->name;
    }
}
