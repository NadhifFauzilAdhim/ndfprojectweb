<?php

namespace App\Http\Controllers\Tools;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use App\Services\ApiServices;

class IpLookupController extends Controller
{
    public function index(Request $request, ApiServices $apiServices)
    {
        $data  = null;
        $error = null;

        if ($request->filled('ip')) {

            $validator = Validator::make($request->all(), [
                'ip' => ['required', 'ip'],
            ]);

            if ($validator->fails()) {
                return back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $ip = trim($request->input('ip'));

            $result = $apiServices->ipLookup($ip);

            if ($result['success']) {
                $data = $result['data'];
            } else {
                $error = $result['message'];
            }
        }

        return view('tools.iplookup.index', compact('data', 'error'));
    }
}
