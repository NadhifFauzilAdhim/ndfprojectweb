<?php

namespace App\Http\Controllers\Tools;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApiTesterController extends Controller
{
    public function index()
    {
        return view('tools.apitester.index');
    }
}
