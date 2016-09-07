<?php

namespace Tamkeen\Ajeer\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class RatingModels
 * @package Tamkeen\Ajeer\Models
 */
class RatingModels extends BaseModel
{
    use SoftDeletes;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'taqyeem_template';

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
     * OneToMany Relationship with model TaqyeemTemplateItems
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function taqyeemTemplateItems()
    {
        return $this->hasMany(TaqyeemTemplateItems::class, "taqyeem_template_id");
    }

    /**
     * OneToMany Relationship with model Taqyeems
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function taqyeems()
    {
        return $this->hasMany(Taqyeems::class, "taqyeem_template_id");
    }

    /**
     * OneToMany Relationship with model TaqyeemTemplatePermission
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function taqyeemTemplatePermission()
    {
        return $this->hasMany(TaqyeemTemplatePermission::class, "taqyeem_template_id");
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function items()
    {
        return $this->belongsToMany(TaqyeemItems::class, "taqyeem_template_items", "taqyeem_template_id",
            "taqyeem_item_id")
            ->withPivot('created_by', 'updated_by')
            ->withTimestamps();
    }


}
