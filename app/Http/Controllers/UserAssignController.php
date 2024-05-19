<?php

namespace App\Http\Controllers;

use App\Models\DesignJob;
use App\Models\DesignJobEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserAssignController extends Controller
{
    //

    public function assignCreator(Request $request, DesignJob $designJob): \Illuminate\Http\RedirectResponse
    {

        $request->validate([
            'creator_user_id' => ['required','integer'],
        ]);

        $designJob->creator_id=$request->creator_user_id;
        $designJob->save();

        $id = Auth::id();
        $event =  DesignJobEvent::create([
            'user_id' => $id,
            'design_job_id' => $designJob->id,
            'event'=>'assigned_creator',
            'message'=>'A new creator assigned.'
        ]);

        $request->session()->flash('flash.bannerStyle', 'success');
        $request->session()->flash('flash.banner', 'Linked Creator');
        return redirect()->back();


    }

    public function assignPm(Request $request, DesignJob $designJob): \Illuminate\Http\RedirectResponse
    {

        $request->validate([
            'pm_user_id' => ['required','integer'],
        ]);

        $designJob->pm_id=$request->pm_user_id;
        $designJob->save();

        $id = Auth::id();
        $event =  DesignJobEvent::create([
            'user_id' => $id,
            'design_job_id' => $designJob->id,
            'event'=>'assigned_pm',
            'message'=>'A new Project Manager assigned.'
        ]);

        $request->session()->flash('flash.bannerStyle', 'success');
        $request->session()->flash('flash.banner', 'Linked PM');
        return redirect()->back();


    }
}
