<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class DesignJob extends Model
{
    use HasFactory;
    use SoftDeletes;


/*$table->bigInteger('del_id')->unsigned();
$table->bigInteger('del_sub_id')->unsigned();
$table->bigInteger('style_ref_id')->unsigned();*/

    public $fillable = ['del_id','del_sub_id','style_ref_id','user_id','pm_id','creator_id','design_job_status_id','design_brief_id','payment_type_id','payment_status_id'];

    public function JobStatus(): BelongsTo
    {
        return $this->belongsTo(DesignJobStatus::class,'design_job_status_id');
    }

    public function PaymentType(): BelongsTo
    {
        return $this->belongsTo(PaymentType::class,'payment_type_id');
    }

    public function PaymentStatus(): BelongsTo
    {
        return $this->belongsTo(PaymentType::class,'payment_status_id');
    }

    public function DesignBrief(): BelongsTo
    {
        return $this->belongsTo(DesignBrief::class,'design_brief_id');
    }

    public function DesignJobEvents(): HasMany
    {
        return $this->hasMany(DesignJobEvent::class);
    }
}
