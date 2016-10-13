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

    public function taqyeemsTemplateItems()
    {
        return $this->belongsTo(TaqyeemTemplateItems::class, "taqyeem_template_item_id");
    }

    public function degrees()
    {
    	return $this->belongsTo(TaqyeemDegrees::class, "degrees_id");
    }

    public function taqyeems()
    {
    	return $this->belongsTo(Taqyeems::class, "taqyeems_id");
    }
}
