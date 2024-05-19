<?php

namespace App\Http\Controllers;

use App\Models\DesignBrief;
use App\Models\FileStore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use function MongoDB\BSON\toJSON;

class DesignBriefController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $id = Auth::id();

        if($request->hasFile('file_1')) {

            $file_assets = $request->file('file_1')->store(options: 'public');
            $url = Storage::url($file_assets);
            $fileName = $request->file('file_1')->getClientOriginalName();

            $design_brief = DesignBrief::create([
                'client_name' => $request->name,
                'asset_link'=>$url,
                'file_link' => $file_assets,
                'file_name' => $fileName,
                'file_public_url' => $url,
                'type' => $request->type,
                'user_id'=>$id,
                'goals_of_social_media' => $request->sm_goals,
                'target_audience' => $request->sm_target_audience,
                'brand_rules' => $request->sm_brand_rules,
                'guidelines_of_engagement' => $request->sm_guidelines,
                'desired_tone_of_voice' => $request->sm_desired_tone,
                'brand_personality_desc' => $request->sm_brand_personality,
                'type_of_content' => $request->content_included,
                'posting_frequency' => $request->sm_reporting_frequency,
                'kpi' => $request->sm_kpi,
                'reporting_frequency' => $request->sm_reporting_frequency,
                'words_to_avoid' => $request->sm_words_to_avoid,
                'words_to_use' => $request->sm_words_to_use,
                'emoji_to_avoid' => $request->sm_emoji_to_avoid,
                'emoji_to_use' => $request->sm_emoji_to_use,
                'person_to_sign_off' => $request->sm_responsible,
                'brand_colours' => $request->sm_brand_colors,
                'additional_notes' => $request->additional_notes,
                'sm_platforms' => $request->sm_platforms,


            ]);

            return $design_brief;
        }
        else{
            $design_brief = DesignBrief::create([
                'client_name' => $request->name,
                'type' => $request->type,
                'user_id'=>$id,
                'file_link'=>null,
                'goals_of_social_media' => $request->sm_goals,
                'target_audience' => $request->sm_target_audience,
                'brand_rules' => $request->sm_brand_rules,
                'guidelines_of_engagement' => $request->sm_guidelines,
                'desired_tone_of_voice' => $request->sm_desired_tone,
                'brand_personality_desc' => $request->sm_brand_personality,
                'type_of_content' => $request->content_included,
                'posting_frequency' => $request->sm_reporting_frequency,
                'kpi' => $request->sm_kpi,
                'reporting_frequency' => $request->sm_reporting_frequency,
                'words_to_avoid' => $request->sm_words_to_avoid,
                'words_to_use' => $request->sm_words_to_use,
                'emoji_to_avoid' => $request->sm_emoji_to_avoid,
                'emoji_to_use' => $request->sm_emoji_to_use,
                'person_to_sign_off' => $request->sm_responsible,
                'brand_colours' => $request->sm_brand_colors,
                'additional_notes' => $request->additional_notes,
                'sm_platforms' => $request->sm_platforms,

            ]);

            return $design_brief;
        }



    }

    /**
     * Display the specified resource.
     */
    public function show(DesignBrief $designBrief)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DesignBrief $designBrief)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DesignBrief $designBrief)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DesignBrief $designBrief)
    {
        //
    }
}
