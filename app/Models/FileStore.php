<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class FileStore extends Model
{
    use HasFactory;

   // use SoftDeletes;

    public $fillable = ['file_type_id','design_job_id','user_id','client_id','pm_id','comments','pm_comments','client_comments','file_link','file_name','file_public_url','is_approved','is_client_approved'];

    public function FileType(): BelongsTo
    {
        return $this->belongsTo(FileType::class,'file_type_id');
    }

}
