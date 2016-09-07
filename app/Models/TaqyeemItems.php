<?php

namespace Tamkeen\Ajeer\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TaqyeemItems
 * @package Tamkeen\Ajeer\Models
 */
class TaqyeemItems extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'taqyeem_items';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function Taqyeem()
    {
        return $this->belongsToMany(RatingModels::class, "taqyeem_template_items", "taqyeem_template_id",
            "taqyeem_item_id")
            ->withPivot('created_by', "updated_by")
            ->withTimestamps();
    }

    public function degrees()
    {
        return $this->hasMany(TaqyeemDegrees::class, "taqyeem_item_id");
    }

}

