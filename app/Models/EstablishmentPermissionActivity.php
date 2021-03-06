<?php

namespace Tamkeen\Ajeer\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EstablishmentPermissionActivity extends Model
{
    protected $guarded = ['id'];
    protected $table = 'est_permission_activities';

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }
}
