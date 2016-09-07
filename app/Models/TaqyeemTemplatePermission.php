<?php

namespace Tamkeen\Ajeer\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Temp Model For TaqyeemTemplatePermission
 * Using It for Rating Model Check Deletes
 * Class TaqyeemTemplatePermission
 * @package Tamkeen\Ajeer\Models
 */
class TaqyeemTemplatePermission extends Model
{
    use SoftDeletes;

    protected $table = 'taqyeem_template_permission';
    protected $dates = ['deleted_at'];

    public function ratingModels()
    {
        return $this->belongsTo(RatingModels::class, "taqyeem_template_id");
    }
}
