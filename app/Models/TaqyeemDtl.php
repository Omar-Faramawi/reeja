<?php

namespace Tamkeen\Ajeer\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Temp Model For TaqyeemTemplateItems
 * Using It for Rating Model Check Deletes
 * Class TaqyeemTemplateDtl
 * @package Tamkeen\Ajeer\Models
 */
class TaqyeemDtl extends BaseModel
{

    use SoftDeletes;

    protected $table = 'taqyeem_dtl';
    protected $dates = ['deleted_at'];

    public function ratingModels()
    {
        return $this->belongsTo(RatingModels::class, "taqyeem_template_item_id");
    }
}
