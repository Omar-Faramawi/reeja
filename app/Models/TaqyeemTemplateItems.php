<?php

namespace Tamkeen\Ajeer\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

/**
 * Temp Model For TaqyeemTemplateItems
 * Using It for Ratind Model Check Deletes
 * Class TaqyeemTemplateItems
 * @package Tamkeen\Ajeer\Models
 */
class TaqyeemTemplateItems extends BaseModel
{
    use SoftDeletes;

    protected $table = 'taqyeem_template_items';
    protected $dates = ['deleted_at'];

    public function ratingModels()
    {
        return $this->belongsTo(RatingModels::class, "taqyeem_template_id");
    }
}
