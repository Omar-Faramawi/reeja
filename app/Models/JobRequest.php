<?php

namespace Tamkeen\Ajeer\Models;

use Illuminate\Database\Eloquent\Model;

class JobRequest extends BaseModel
{
    protected $table = 'job_requests';
    
    protected $guarded = [];
    
    public function hrPool()
    {
        return $this->belongsTo(HRPool::class, 'hr_pool_id_number');
    }
    
    public function vacancy()
    {
        return $this->belongsTo(Vacancy::class, 'vacancies_id');
    }
    
    public function contract()
    {
        return $this->hasMany(Contract::class);
    }
}
