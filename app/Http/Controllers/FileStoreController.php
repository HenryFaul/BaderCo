<?php

namespace App\Http\Controllers;

use App\Models\DesignBrief;
use App\Models\DesignJob;
use App\Models\DesignJobEvent;
use App\Models\FileStore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FileStoreController extends Controller
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

        /*     design_job_id:props.designJob.id,
         file_1: null,
         file_type_id:1,
         comments:null*/

        $request->validate([
            'design_job_id' => ['required', 'integer'],
            'file_type_id' => ['required', 'integer'],
            'comments' => ['required', 'string'],
            'file_1' => ['required', 'file'],
        ]);

        if ($request->hasFile('file_1')) {

            //['file_type_id','design_job_id','user_id','client_id','pm_id','comments','file_link','is_approved'];

            $id = Auth::id();
            //Storage::makeDirectory('test/' . $id);

            $file_assets = $request->file('file_1')->store(options: 'public');
            // $file_assets = $request->file('file_1')->store( 'demo');
            //$path = $request->file('avatar')->store('avatars');
            $url = Storage::url($file_assets);
            $fileName = $request->file('file_1')->getClientOriginalName();

            $design_job = DesignJob::where('id',$request->design_job_id)->first();

            if ($design_job != null){
                $design_job->design_job_status_id = 6;
                $design_job->save();
            }

            $file_store = FileStore::create([
                'file_type_id' => $request->file_type_id,
                'design_job_id' => $request->design_job_id,
                'user_id' => $id,
                'client_id' => $id,
                'pm_id' => $id,
                'comments' => 'Creator comments: ' . $request->comments,
                'file_link' => $file_assets,
                'file_name' => $fileName,
                'file_public_url' => $url,
                'is_approved' => 0,
            ]);

            $event = DesignJobEvent::create([
                'user_id' => $id,
                'design_job_id' => $request->design_job_id,
                'event' => 'status_update',
                'message' => 'New File uploaded.'
            ]);

            $event = DesignJobEvent::create([
                'user_id' => $id,
                'design_job_id' => $request->design_job_id,
                'event' => 'status_update',
                'message' => 'PM To review file'
            ]);

        }


    }

    public function download(Request $request)
    {

        $url = Storage::url($request->file_name);
        dd($url);

        $request->validate([
            'file_name' => ['required', 'file'],
        ]);

        $url = Storage::url($request->file_name);
        dd($url);

    }

    public function download2(Request $request, $filename)
    {

        $path = Storage::disk('log_brand_assets')->path($filename);

        return $path;

    }


    /**
     * Display the specified resource.
     */
    public function show(FileStore $fileStore)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FileStore $fileStore)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FileStore $fileStore): \Illuminate\Http\RedirectResponse
    {

        $request->validate([
            'is_approved' => ['required', 'integer'],
            'file_store_id' => ['required', 'integer'],
            'comments' => ['required', 'string'],
            'perspective'=> ['required', 'string'],
        ]);

        if($request->perspective === 'PM'){

            $new_comments = $fileStore->pm_comments."\n".'PM comments: ' . $request->comments;

            $fileStore->update(
                [
                    'is_approved' => $request->is_approved,
                    'pm_comments' => $new_comments
                ]);
        } else{

            $new_comments = $fileStore->client_comments."\n".'Client comments: ' . $request->comments;

            $fileStore->update(
                [
                    'is_client_approved' => $request->is_client_approved,
                    'client_comments' => $new_comments
                ]);
        }


        $id = Auth::id();

        $event = DesignJobEvent::create([
            'user_id' => $id,
            'design_job_id' => $fileStore->design_job_id,
            'event' => 'file_update',
            'message' => 'File status updated.'
        ]);


        $request->session()->flash('flash.bannerStyle', 'success');
        $request->session()->flash('flash.banner', 'Updated');


        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FileStore $fileStore)
    {
        //
    }
}
