<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class DesignJobEvent extends Model
{
    use HasFactory;

    use SoftDeletes;

    public $fillable = ['user_id','design_job_id','event','message'];

    public function DesignJob(): BelongsTo
    {
        return $this->belongsTo(DesignJob::class,'design_job_id');
    }

}
