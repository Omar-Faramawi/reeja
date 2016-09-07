<?php

namespace Tamkeen\Ajeer\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Size
 * @package Tamkeen\Ajeer\Models
 */
class Size extends BaseModel
{

    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'est_sizes';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

   
}
