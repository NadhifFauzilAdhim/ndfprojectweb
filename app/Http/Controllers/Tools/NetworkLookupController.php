<?php

namespace App\Http\Controllers\Tools;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use App\Services\RdapService;
class NetworkLookupController extends Controller
{
    public function index(Request $request, RdapService $rdapService)
{
    $data = null;
    $parsedData = null;
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

        $result = $rdapService->lookup($ip);

        if ($result['success']) {
            $data       = $result['data'];
            $parsedData = $result['parsed'];
        } else {
            $error = $result['message'];
        }
    }

    return view('tools.networklookup.index', compact('data', 'parsedData', 'error'));
}
}
