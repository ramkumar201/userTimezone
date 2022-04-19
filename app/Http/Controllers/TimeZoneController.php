<?php

namespace App\Http\Controllers;

use App\Models\TimeZoneLog;
use App\Models\TimeZoneUser;
use Illuminate\Http\Request;
use DateTimeZone;
use Inertia\Inertia;

class TimeZoneController extends Controller
{
    public function index()
    {
        $list_Timezones = DateTimeZone::listIdentifiers();
        $lasttimezone = TimeZoneLog::all()->last();
        return Inertia::render('TimeZone/index', [
            'timezone' =>   $list_Timezones,
            'lasttimezone' => $lasttimezone
        ]);
    }

    public function updateTimeZone(Request $request)
    {
        try {
            $currentDate = date('Y-m-d');

            TimeZoneLog::create([
                'from' => $request->fromZone,
                'to' => $request->toZone,
            ]);

            // $getUserCount = TimeZoneUser::where('date', $currentDate)->first();
            // if($getUserCount) {
            //     $data = array(
            //         'daycount' => $getUserCount->daycount + 1,
            //     );
            //     $getUserCount->update($data);
            // } else {
            //     $data = array(
            //         'daycount' => 1,
            //         'date' => $currentDate,
            //     );
            //     TimeZoneUser::create($data);
            // }

            return response()->json(['statusCode' => 200, 'message' => 'Timezone updated']);
        } catch (\exception $e) {
            return response()->json(['statusCode' => 500, 'message' => $e]);
        }
    }

    public function updateUsercount()
    {
        try {
            $currentDate = date('Y-m-d');
            $getUserCount = TimeZoneUser::where('date', $currentDate)->first();
            if($getUserCount) {
                $data = array(
                    'daycount' => $getUserCount->daycount + 1,
                );
                $getUserCount->update($data);
            } else {
                $data = array(
                    'daycount' => 1,
                    'date' => $currentDate,
                );
                TimeZoneUser::create($data);
            }
            return response()->json(['statusCode' => 200, 'message' => 'Site visitor count updated.']);
        } catch (\exception $e) {
            return response()->json(['statusCode' => 500, 'message' => $e]);
        }
    }
}
