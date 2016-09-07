<?php

namespace Tamkeen\Ajeer\Models;

use Illuminate\Database\Eloquent\Model;

class TaqyeemDegrees extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'taqyeem_degrees';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    public function items()
    {
        return $this->belongsTo(TaqyeemItems::class, "taqyeem_item_id");
    }
}
