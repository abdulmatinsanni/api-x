<?php

namespace AbdulmatinSanni\APIx\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

class LogController extends Controller
{
    public function index()
    {
        $log = null;
        $logPath = config('api-x.log_file_path');

        try {
            $log = Storage::get($logPath);
        } catch (FileNotFoundException $exception) {
            Storage::put($logPath, null);
        }

        return view('api-x::log')->with('log', $log);
    }
}
