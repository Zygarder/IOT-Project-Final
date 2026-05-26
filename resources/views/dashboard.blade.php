<x-app-layout>
    <div class="py-8 bg-gray-100 min-h-screen">
        <div class="max-w-4xl mx-auto px-4">
            <h1 class="text-3xl font-bold mb-8 text-gray-800">Hardware Control Center</h1>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                @php
                    $led = $actuators->where('actuator_identity', 'led')->first();
                    $buzzer = $actuators->where('actuator_identity', 'buzzer')->first();
                @endphp

                <div class="bg-white p-6 rounded-lg shadow-md border-t-4 {{ $led->operating_state ? 'border-yellow-400' : 'border-gray-400' }}">
                    <h2 class="text-xl font-semibold mb-2">LED Indicator</h2>
                    <p class="text-sm text-gray-500 mb-4 font-mono">Pin: D2</p>
                    <div class="flex justify-between items-center">
                        <span class="px-3 py-1 rounded-full text-xs font-bold {{ $led->operating_state ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $led->operating_state ? 'ACTIVE' : 'INACTIVE' }}
                        </span>
                        <form action="{{ route('actuator.toggle', 'led') }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded transition">
                                Toggle LED
                            </button>
                        </form>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md border-t-4 {{ $buzzer->operating_state ? 'border-red-600' : 'border-gray-400' }}">
                    <h2 class="text-xl font-semibold mb-2">Active Buzzer</h2>
                    <p class="text-sm text-gray-500 mb-4 font-mono">Pin: D5</p>
                    <div class="flex justify-between items-center">
                        <span class="px-3 py-1 rounded-full text-xs font-bold {{ $buzzer->operating_state ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $buzzer->operating_state ? 'ACTIVE' : 'INACTIVE' }}
                        </span>
                        <form action="{{ route('actuator.toggle', 'buzzer') }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded transition">
                                Toggle Buzzer
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="bg-gray-800 text-white px-6 py-4">
                    <h2 class="text-lg font-semibold">Live Sensor Telemetry</h2>
                </div>
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-gray-50 border-b">
                            <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase">Temp</th>
                            <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase">Hum</th>
                            <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase">Light</th>
                            <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase">Time</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($telemetry as $log)
                        <tr>
                            <td class="px-6 py-4 text-sm font-mono text-red-600">{{ $log->temperature }}°C</td>
                            <td class="px-6 py-4 text-sm font-mono text-blue-600">{{ $log->humidity }}%</td>
                            <td class="px-6 py-4 text-sm font-mono text-gray-600">{{ $log->light_level }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ \Carbon\Carbon::parse($log->created_at)->diffForHumans() }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @if($telemetry->isEmpty())
                    <p class="p-6 text-center text-gray-500">Waiting for data from ESP32...</p>
                @endif
            </div>
        </div>
    </div>

    <script>
        // Auto-refresh every 5 seconds to show new sensor data
        setTimeout(function(){
           window.location.reload();
        }, 5000);
    </script>
</x-app-layout>
