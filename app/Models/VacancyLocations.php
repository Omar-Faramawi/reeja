<?php

namespace Tamkeen\Ajeer\Models;

class VacancyLocations extends BaseModel
{
    //use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'vacancy_locations';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'location',
        'vacancies_id',
        'created_by',
        'updated_by',
    ];
    
     


}
