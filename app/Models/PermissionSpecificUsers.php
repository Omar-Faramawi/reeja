<?php

namespace Tamkeen\Ajeer\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Temp Model For taqyeem_template_permissionon
 * Using It for Rating Model Check Deletes
 * Class TaqyeemTemplatePermission
 * @package Tamkeen\Ajeer\Models
 */
class PermissionSpecificUsers extends BaseModel
{
    protected $table = 'permission_specific_users';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function TaqyeemTemplatePermission()
    {
        return $this->belongsTo(TaqyeemTemplatePermission::class, 'template_permission_id');
    }
}
