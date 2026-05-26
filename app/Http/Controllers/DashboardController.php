<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
{
    return view('dashboard', [
        'actuators' => DB::table('actuator_states')->get(),
        'telemetry' => DB::table('telemetry_logs')->orderBy('created_at', 'desc')->take(10)->get()
    ]);
}
    public function toggle($identity)
    {
        // Matches your columns: 'actuator_identity' and 'operating_state'
        $currentStatus = DB::table('actuator_states')
            ->where('actuator_identity', $identity)
            ->value('operating_state');

        DB::table('actuator_states')
            ->where('actuator_identity', $identity)
            ->update([
                'operating_state' => !$currentStatus,
                'updated_at' => now(),
            ]);

        return back();
    }
}
