<?php

namespace App\Http\Controllers;

use App\Models\DesignJob;
use App\Models\FileStore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArtworkController extends Controller
{
    //

    public function index()
    {
        $id = Auth::id();
        $is_admin = (Auth::user()?->getPermissionsViaRoles()->unique('name')->pluck('name')->contains('admin'));
        $is_pm = (Auth::user()?->getPermissionsViaRoles()->unique('name')->pluck('name')->contains('admin'));
        $is_creator = (Auth::user()?->getPermissionsViaRoles()->unique('name')->pluck('name')->contains('admin'));
        $is_client = (Auth::user()?->getPermissionsViaRoles()->unique('name')->pluck('name')->contains('admin'));

        if ($is_admin){
            $all_files = FileStore::where('is_approved',true)->with('FileType')->get();
        } elseif ($is_pm){
            $all_files = FileStore::where('is_approved',true)->where('pm_id',$id)->with('FileType')->get();

        } elseif ($is_creator){
            $all_files = FileStore::where('is_approved',true)->where('user_id',$id)->with('FileType')->get();
        } else {
            $all_files = FileStore::where('is_approved',true)->where('client_id',$id)->with('FileType')->get();
        }


        return inertia(
            'Art/Index',
            [
                'all_files'=>$all_files
            ]
        );
    }
}
