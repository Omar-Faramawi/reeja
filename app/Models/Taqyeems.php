<?php

namespace Tamkeen\Ajeer\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Temp Model For TaqyeemTemplateItems
 * Using It for Ratind Model Check Deletes
 * Class TaqyeemTemplateItems
 * @package Tamkeen\Ajeer\Models
 */
class Taqyeems extends BaseModel
{

    protected $table = 'taqyeems';

    public function ratingModels()
    {
        return $this->belongsTo(RatingModels::class, "taqyeem_template_id");
    }

    public function taqyeemDtl()
    {
    	return $this->hasMany(TaqyeemDtl::class, "taqyeems_id");
    }
}
