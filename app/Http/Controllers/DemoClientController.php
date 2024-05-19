<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class DemoClientController extends Controller
{
    //

    public function index(Request $request)
    {



        return inertia(
            'Demo/Client/DemoProcess',
            [

            ]
        );
    }
}
