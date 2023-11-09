<?php

namespace App\Http\Controllers;

use App\Models\DesignBrief;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $request->validate([
            'name' => ['required','string'],
            'type' => ['nullable','string'],
        ]);

        $id = Auth::id();

        $design_brief = DesignBrief::create([
            'client_name' => $request->name,
            'type' => $request->type,
            'user_id'=>$id
        ]);

        return $design_brief;

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
