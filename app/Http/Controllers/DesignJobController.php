<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\DesignJob;
use App\Models\DesignJobEvent;
use App\Models\DesignJobStatus;
use App\Models\FileStore;
use App\Models\FileType;
use App\Models\PaymentStatus;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DesignJobController extends Controller
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
            $all_jobs = DesignJob::with('JobStatus')->with('PaymentType')->with('PaymentStatus')->get();
        } elseif ($is_pm){
            $all_jobs = DesignJob::where('pm_id',$id)->with('JobStatus')->with('PaymentType')->with('PaymentStatus')->get();
        } elseif ($is_creator){
            $all_jobs = DesignJob::where('creator',$id)->with('JobStatus')->with('PaymentType')->with('PaymentStatus')->get();
        } else {
            $all_jobs = DesignJob::where('user_id',$id)->with('JobStatus')->with('PaymentType')->with('PaymentStatus')->get();
        }


        return inertia(
            'DesignJobs/Index',
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
        return inertia(
            'DesignJobs/NewJob',
            [

            ]
        );
    }


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
            'payment_status_id'=>1,
            'del_id'=>$request->del_id,
            'del_sub_id'=>$request->del_sub_id,
            'style_ref_id'=>$request->style_ref_id,
        ]);

        $event =  DesignJobEvent::create([
            'user_id' => $id,
            'design_job_id' => $design_job->id,
            'event'=>'job_created',
            'message'=>'A new job was created.'
        ]);

        return $design_job;


/*       if ($design_job->exists()){
            $request->session()->flash('flash.bannerStyle', 'success');
            $request->session()->flash('flash.banner', $design_job->id);
        }else{
            $request->session()->flash('flash.bannerStyle', 'danger');
            $request->session()->flash('flash.banner', 'Design Job Not created');
        }

        return redirect()->back();*/
    }

    /**
     * Display the specified resource.
     */
    public function show(DesignJob $designJob)
    {
        $id = Auth::id();
        $is_admin = (Auth::user()?->getPermissionsViaRoles()->unique('name')->pluck('name')->contains('admin'));
        $is_pm = (Auth::user()?->getPermissionsViaRoles()->unique('name')->pluck('name')->contains('admin'));
        $is_creator = (Auth::user()?->getPermissionsViaRoles()->unique('name')->pluck('name')->contains('admin'));
        $is_client = (Auth::user()?->getPermissionsViaRoles()->unique('name')->pluck('name')->contains('admin'));

        if ($is_admin){
            $can_view =true;
        } elseif ($is_pm){
            $can_view= $designJob->pm_id == $id;

        } elseif ($is_creator){
            $can_view= $designJob->creator_id == $id;
        } else {
            $can_view= $designJob->user_id == $id;
        }

        if(!$can_view){
            abort(403);
        } else{
            $designJob->load('DesignBrief');
            $all_design_job_statuses = DesignJobStatus::all();
            $all_payment_statuses = PaymentStatus::all();
            $all_users = User::all();
            $all_events = DesignJobEvent::where('design_job_id',$designJob->id)->get();
            $all_file_types = FileType::all();
            $status_array = array(
                array('id' => '01', 'name' => 'Created', 'href' => '#', 'status' => 1 < $designJob->design_job_status_id ? 'complete' : (1 === $designJob->design_job_status_id ? 'current' : 'upcoming')),
                array('id' => '02', 'name' => 'Cancelled', 'href' => '#', 'status' => 2 < $designJob->design_job_status_id ? 'complete' : (2 === $designJob->design_job_status_id ? 'current' : 'upcoming')),
                array('id' => '03', 'name' => 'Allocated', 'href' => '#', 'status' => 3 < $designJob->design_job_status_id ? 'complete' : (3 === $designJob->design_job_status_id ? 'current' : 'upcoming')),
                array('id' => '04', 'name' => 'Pending', 'href' => '#', 'status' => 4 < $designJob->design_job_status_id ? 'complete' : (4 === $designJob->design_job_status_id ? 'current' : 'upcoming')),
                array('id' => '05', 'name' => 'Final', 'href' => '#', 'status' => 5 < $designJob->design_job_status_id ? 'complete' : (5 === $designJob->design_job_status_id ? 'current' : 'upcoming')),
                array('id' => '06', 'name' => 'Closed', 'href' => '#', 'status' => 6 < $designJob->design_job_status_id ? 'complete' : (6 === $designJob->design_job_status_id ? 'current' : 'upcoming')),
            );
            $all_files= FileStore::where('design_job_id',$designJob->id)->with('FileType')->get();
            return inertia(
                'DesignJobs/Show',
                [
                    'designJob'=>$designJob,
                    'all_design_job_statuses'=>$all_design_job_statuses,
                    'all_users'=>$all_users,
                    'all_events'=>$all_events,
                    'status_array'=>$status_array,
                    'all_file_types'=>$all_file_types,
                    'all_files'=>$all_files,
                    'all_payment_statuses'=>$all_payment_statuses
                ]
            );
        }

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

    public function updateStatus(Request $request,DesignJob $designJob): \Illuminate\Http\RedirectResponse
    {


        $request->validate([
            'design_job_status_id' => ['required','integer'],
            'design_job_id'=> ['required','integer'],
            'comments' => ['required','string'],
        ]);

      $designJob->update(['design_job_status_id'=>$request->design_job_status_id]);

        $id = Auth::id();

        $event =  DesignJobEvent::create([
            'user_id' => $id,
            'design_job_id' => $designJob->id,
            'event'=>'status_update',
            'message'=>$request->comments
        ]);


        $request->session()->flash('flash.bannerStyle', 'success');
        $request->session()->flash('flash.banner', 'Updated');

        return redirect()->back();
    }

    public function updatePaymentStatus(Request $request,DesignJob $designJob): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'payment_status_id' => ['required','integer'],
            'design_job_id'=> ['required','integer'],
        ]);

        $designJob->update(['payment_status_id'=>$request->payment_status_id]);

        $id = Auth::id();

        $event =  DesignJobEvent::create([
            'user_id' => $id,
            'design_job_id' => $designJob->id,
            'event'=>'payment_update',
            'message'=>'Payment status update'
        ]);


        $request->session()->flash('flash.bannerStyle', 'success');
        $request->session()->flash('flash.banner', 'Updated');

        return redirect()->back();
    }
}
