<?php

namespace Tamkeen\Ajeer\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Vinkla\Hashids\Facades\Hashids;

class BaseModel extends Model
{
    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        if ( ! auth()->check()) {
            return;
        }
        $user_id = auth()->id();

        //created_by & updated_by
        static::creating(function ($model) use ($user_id) {
            $model->created_by = $user_id;
            $model->updated_by = $user_id;
        });

        static::updating(function ($model) use ($user_id) {
            $model->updated_by = $user_id;
        });
    }

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['hashids'];

    /**
     * The hashids method converter
     *
     * @return encode model id
     */
    public function getHashidsAttribute()
    {
        return Hashids::encode($this->id);
    }

    /**
     * The return by hashid method.
     *
     * @param  string $query
     * @param  string $value
     * @param  boolean $notHash
     *
     * @return $query string
     */
    public function scopeById($query, $value, $notHash = false)
    {
        if ( ! $notHash) {
            $value = Hashids::decode($value);
        }

        return $query->where('id', $value);
    }


    /**
     * @return integer $currentId
     *
     * We need to have the current login uesr ID across all the models
     * so we get that through this method
     */
    public function getCurrentLoginId()
    {
        if (session()->has('selected_establishment')) {
            $currentUserId = session()->get('selected_establishment.id');
        } elseif (session()->get('government')) {
            $currentUserId = session()->get('government.id');
        } else {
            $currentUserId = \Auth::user()->id_no;
        }

        return (int)$currentUserId;
    }



    /**
     * @param $type
     * @param $id
     *
     * @return mixed
     */
    public static function getName($type, $id)
    {
        try {
            switch ($type) {
                case 4:
                case 5:
                    return Individual::findOrFail($id)->name;
                case 2:
                    return Government::findOrFail($id)->name;
                case 3:
                    return Establishment::findOrFail($id)->name;
            }
        } catch (ModelNotFoundException $e) {
            return trans('labels.not_found');
        }
    }

}