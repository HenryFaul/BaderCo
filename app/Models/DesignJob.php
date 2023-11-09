<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DesignJob extends Model
{
    use HasFactory;
    use SoftDeletes;
    public $fillable = ['user_id','pm_id','creator_id','design_job_status_id','design_brief_id','payment_type_id','payment_status_id'];


}
