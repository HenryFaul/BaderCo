<?php

namespace App\Http\Controllers;

use App\Models\DesignJob;
use App\Models\DesignJobEvent;
use App\Models\FileStore;
use App\Models\User;
use App\Models\UserDetail;
use App\Models\UserType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Laravel\Fortify\Rules\Password;
use Spatie\Permission\Models\Role;

class UserDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $permissions = Auth::user()?->getPermissionsViaRoles()->unique('name')->pluck('name');

        $can_view = $permissions?->contains('admin');

        if (!$can_view){
            abort(403);
        }

        $filters = $request->only([
            'searchName',
        ]);


        $paginate = $request['show'] ?? 10;
        $all_users = User::with('roles')->filter($filters)->with('UserDetail',fn($query) => $query->with('UserType'))->paginate($paginate)->withQueryString();


        return inertia(
            'UserDetail/Index',
            [
                'filters' => $filters,
                'all_users' => $all_users,
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
        //'user_id','title','user_type_id','cv_link','is_approved','last_legal_name','first_name'


        $request->validate([
            'first_name' => ['required','string'],
            'last_legal_name' => ['required','string','string'],
            'cv_link' => ['nullable','string'],
            'title' => ['nullable','string'],
            'user_type_id' => ['required','integer'],
            'password_confirmation' => ['required'],
            'password'=> ['required', 'string', new Password,'required_with:password_confirmation','same:password_confirmation'],
            'email'=> ['required', 'string', 'email', 'max:255', 'unique:users'],
        ]);

        $user =  User::create([
            'name' => $request->first_name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        if($user->exists()){
            UserDetail::create([
                'first_name' => $request->first_name,
                'last_legal_name' => $request->last_legal_name,
                'cv_link' => $request->cv_link,
                'title' => $request->title,
                'user_type_id' => $request->user_type_id,
                'user_id'=> $user->id
            ]);

            $request->session()->flash('flash.bannerStyle', 'success');
            $request->session()->flash('flash.banner', 'Staff created');
        }


        return redirect()->back();

    }

    /**
     * Display the specified resource.
     */
    public function show(UserDetail $userDetail): \Inertia\Response|\Inertia\ResponseFactory
    {
        $userDetail = User::where('id','=',$userDetail->user_id)->with('roles')->with('UserDetail')->first();

        $all_roles_in_database = Role::all();
        $permissions = $userDetail?->getPermissionsViaRoles()->unique('name')->pluck('name');
        $all_user_types = UserType::all();
        $id = Auth::id();

        $can_view = (Auth::user()?->getPermissionsViaRoles()->unique('name')->pluck('name')->contains('admin') || $id === $userDetail->id);

          if (!$can_view){
            abort(403);
        }

        return inertia(
            'UserDetail/Show',
            [
                'user_detail' => $userDetail,
                'all_roles'=>$all_roles_in_database,
                'permissions'=>$permissions,
                'all_user_types'=>$all_user_types
            ]
        );
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserDetail $userDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UserDetail $userDetail): \Illuminate\Http\RedirectResponse
    {

        //Update the system user first name field to align with staff
        $user = $userDetail->User()->first();

        dd($request);

        if ($request->email != $user->email){
            $request->validate([
                'email'=> ['required', 'string', 'email', 'max:255', 'unique:users'],
            ]);
        }

        if ($request->password != null || $request->password !=''){
            $request->validate([
                'password'=> ['required', 'string', new Password],
            ]);
        }

        $userDetail->update(
            $request->validate([
                'first_name' => ['required','string'],
                'last_legal_name' => ['required','string','string'],
                'cv_link' => ['nullable','string'],
                'about_you' => ['nullable','string'],
                'title' => ['nullable','string'],
                'user_type_id' => ['required','integer'],
                'is_approved' => ['required','boolean'],
                'is_available' => ['required','boolean'],
                'is_active' => ['required','boolean'],
            ])
        );


        if($user->exists() ){
            if($request->password != null && $request->password != ''){
                $user->update([
                    'name' => $request->first_name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password)
                ]);
            }else{
                $user->update([
                    'name' => $request->first_name,
                    'email' => $request->email
                ]);
            }


        }

        $request->session()->flash('flash.bannerStyle', 'success');
        $request->session()->flash('flash.banner', 'User Detail updated');

        return redirect()->back();
    }

    public function updateCustom(Request $request): \Illuminate\Http\RedirectResponse
    {

        $userDetail=UserDetail::where('id',$request->user_detail_id)->first();

        //Update the system user first name field to align with staff
        $user = $userDetail->User()->first();

        if ($request->email != $user->email){
            $request->validate([
                'email'=> ['required', 'string', 'email', 'max:255', 'unique:users'],
            ]);
        }

        if ($request->password != null || $request->password !=''){
            $request->validate([
                'password'=> ['required', 'string', new Password],
            ]);
        }

        if ($request->hasFile('file_1')) {

            //['file_type_id','design_job_id','user_id','client_id','pm_id','comments','file_link','is_approved'];

            $id = Auth::id();


            $file_assets = $request->file('file_1')->store(options: 'public');
            $url = Storage::url($file_assets);
            $fileName = $request->file('file_1')->getClientOriginalName();

            $request->validate([
                'first_name' => ['required','string'],
                'last_legal_name' => ['required','string','string'],
                'about_you' => ['nullable','string'],
                'title' => ['nullable','string'],
                'user_type_id' => ['required','integer'],
                'is_approved' => ['required','boolean'],
                'is_available' => ['required','boolean'],
                'is_active' => ['required','boolean'],
            ]);

            $userDetail->update(
                [
                    'first_name' => $request->first_name,
                    'last_legal_name' => $request->last_legal_name,
                    'about_you' => $request->about_you,
                    'title' => $request->title,
                    'user_type_id' => $request->user_type_id,
                    'is_approved' => $request->is_approved,
                    'is_available' => $request->is_available,
                    'is_active' => $request->is_active,
                    'cv_link' => $url,
                ]
            );


        } else {

            $userDetail->update(
                $request->validate([
                    'first_name' => ['required','string'],
                    'last_legal_name' => ['required','string','string'],
                    'about_you' => ['nullable','string'],
                    'title' => ['nullable','string'],
                    'user_type_id' => ['required','integer'],
                    'is_approved' => ['required','boolean'],
                    'is_available' => ['required','boolean'],
                    'is_active' => ['required','boolean'],
                ])
            );
        }


        if($user->exists() ){
            if($request->password != null && $request->password != ''){
                $user->update([
                    'name' => $request->first_name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password)
                ]);
            }else{
                $user->update([
                    'name' => $request->first_name,
                    'email' => $request->email
                ]);
            }


        }

        $request->session()->flash('flash.bannerStyle', 'success');
        $request->session()->flash('flash.banner', 'User Detail updated');

        return redirect()->back();
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserDetail $userDetail)
    {
        //
    }
}
