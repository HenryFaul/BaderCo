<?php

namespace App\Http\Controllers;

use App\Models\DesignJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DesignJobController extends Controller
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
        //    public $fillable = ['user_id','pm_id','creator_id','design_job_status_id','design_brief_id','payment_type_id','payment_status_id'];

        $request->validate([
            'design_brief_id' => ['required','integer'],
        ]);

        $id = Auth::id();

        $design_job = DesignJob::create([
            'design_brief_id' => $request->design_brief_id,
            'user_id'=>$id,
            'pm_id'=>1,
            'creator_id'=>1,
            'design_job_status_id'=>1,
            'payment_type_id'=>3,
            'payment_status_id'=>1

        ]);


        if ($design_job->exists()){
            $request->session()->flash('flash.bannerStyle', 'success');
            $request->session()->flash('flash.banner', 'Design Job Created');
        }else{
            $request->session()->flash('flash.bannerStyle', 'danger');
            $request->session()->flash('flash.banner', 'Design Job Not created');
        }

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(DesignJob $designJob)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DesignJob $designJob)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DesignJob $designJob)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DesignJob $designJob)
    {
        //
    }
}
