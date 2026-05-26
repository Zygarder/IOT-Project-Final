<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Models\TelemetryLog;
use App\Models\ActuatorState;

// Sensor Ingestion Gateway: Hardware sends data here [cite: 30]
Route::post('/telemetry', function (Request $request) {
    // This takes the JSON from your ESP32 and puts it into the DB
    DB::table('telemetry_logs')->insert([
        'temperature' => $request->temperature,
        'humidity' => $request->humidity,
        'light_level' => $request->light_level,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return response()->json(['status' => 'success'], 200);
});

// Hardware Status Dispatcher: Hardware asks for actuator states [cite: 31]
Route::get('/hardware-status', function () {
    return response()->json([
        'led' => (bool) DB::table('actuator_states')->where('actuator_identity', 'led')->value('operating_state'),
        'buzzer' => (bool) DB::table('actuator_states')->where('actuator_identity', 'buzzer')->value('operating_state'),
    ]);
});
