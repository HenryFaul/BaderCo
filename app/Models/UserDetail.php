<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserDetail extends Model
{
    use HasFactory;
    use SoftDeletes;
    public $fillable = ['user_id','title','user_type_id','cv_link','is_approved','last_legal_name','first_name','about_you','is_available','is_active','cell_no'];

    public function User(): belongsTo
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function UserType(): belongsTo
    {
        return $this->belongsTo(UserType::class,'user_type_id');
    }
}
