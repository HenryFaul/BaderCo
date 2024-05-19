<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DesignBrief extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $fillable = ['client_name','type','user_id','brand','goals_of_social_media','target_audience','brand_rules','guidelines_of_engagement',
        'desired_tone_of_voice','brand_personality_desc','type_of_content','posting_frequency','kpi','reporting_frequency',
        'words_to_avoid','words_to_use','emoji_to_avoid','emoji_to_use','person_to_sign_off','brand_colours','asset_link','sm_platforms','additional_notes',
        'file_link','file_name','file_public_url'];
}
