<?php

namespace Tamkeen\Ajeer\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Temp Model For TaqyeemTemplateItems
 * Using It for Ratind Model Check Deletes
 * Class TaqyeemTemplateItems
 * @package Tamkeen\Ajeer\Models
 */
class Taqyeems extends BaseModel
{
    use SoftDeletes;

    protected $table = 'taqyeems';
    protected $dates = ['deleted_at'];

    public function ratingModels()
    {
        return $this->belongsTo(RatingModels::class, "taqyeem_template_id");
    }
}
