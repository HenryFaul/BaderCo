<?php

namespace App\Http\Controllers;

use App\Models\DesignJob;
use App\Models\DesignJobEvent;
use App\Models\FileStore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DesignJobEventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $id = Auth::id();
        $is_admin = (Auth::user()?->getPermissionsViaRoles()->unique('name')->pluck('name')->contains('admin'));
        $is_pm = (Auth::user()?->getPermissionsViaRoles()->unique('name')->pluck('name')->contains('admin'));
        $is_creator = (Auth::user()?->getPermissionsViaRoles()->unique('name')->pluck('name')->contains('admin'));
        $is_client = (Auth::user()?->getPermissionsViaRoles()->unique('name')->pluck('name')->contains('admin'));

        if ($is_admin){
            $all_jobs = DesignJob::with('JobStatus')->with('PaymentType')->with('PaymentStatus')->with('DesignJobEvents')->get();
        } elseif ($is_pm){
            $all_jobs = DesignJob::where('pm_id',$id)->with('JobStatus')->with('PaymentType')->with('PaymentStatus')->with('DesignJobEvents')->get();
        } elseif ($is_creator){
            $all_jobs = DesignJob::where('creator',$id)->with('JobStatus')->with('PaymentType')->with('PaymentStatus')->with('DesignJobEvents')->get();
        } else {
            $all_jobs = DesignJob::where('user_id',$id)->with('JobStatus')->with('PaymentType')->with('PaymentStatus')->with('DesignJobEvents')->get();
        }

        return inertia(
            'Notifications/Index',
            [
                'all_jobs'=>$all_jobs
            ]
        );
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(DesignJobEvent $designJobEvent)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DesignJobEvent $designJobEvent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DesignJobEvent $designJobEvent)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DesignJobEvent $designJobEvent)
    {
        //
    }
}
