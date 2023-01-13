<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class manageController extends Controller
{
    function stop(){
        Storage::disk('manage')->put('stop.txt', '');

    }

}
