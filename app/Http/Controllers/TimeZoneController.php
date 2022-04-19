<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DateTimeZone;
use Inertia\Inertia;

class TimeZoneController extends Controller
{
    public function index()
    {
        $list_Timezones = DateTimeZone::listIdentifiers();
        // dd($list_Timezones);
        return Inertia::render('TimeZone/index', [
            'timezone' =>   $list_Timezones
        ]);
    }

}
