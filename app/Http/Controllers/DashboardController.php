<?php

namespace App\Http\Controllers;

use App\Models\DesignJob;
use App\Models\FileStore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    //
    public function index()
    {
        $id = Auth::id();

        $pending_jobs= DesignJob::where('design_job_status_id','<>',13)->count();
        $completed_jobs= DesignJob::where('design_job_status_id','=',13)->count();
        $files_count = FileStore::all()->count();


        return inertia(
            'Dashboard',
            [
                'pending_jobs'=>$pending_jobs,
                'completed_jobs'=>$completed_jobs,
                'files_count'=>$files_count
            ]
        );
    }
}
