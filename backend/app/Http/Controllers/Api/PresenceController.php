<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Presence;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class PresenceController extends Controller
{
    private const PAC_CENTER_LAT = 6.358653;
    private const PAC_CENTER_LNG = 2.424534;
    private const PAC_RADIUS_METERS = 1200;

    public function index(Request $request): JsonResponse
    {
        $presences = Presence::query()
            ->where('user_id', $request->user()->id)
            ->orderByDesc('date')
            ->orderByDesc('created_at')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $presences,
        ]);
    }

    public function checkIn(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $validator->errors(),
            ], 422);
        }

        $isValid = $this->isInsidePac(
            (float) $request->input('latitude'),
            (float) $request->input('longitude')
        );

        $today = Carbon::today()->toDateString();
        $presence = Presence::firstOrCreate(
            ['user_id' => $request->user()->id, 'date' => $today],
            [
                'heure_arrivee' => now()->toTimeString(),
                'latitude' => $request->input('latitude'),
                'longitude' => $request->input('longitude'),
                'is_valid' => $isValid,
            ]
        );

        if (!$presence->wasRecentlyCreated) {
            $presence->update([
                'heure_arrivee' => $presence->heure_arrivee ?? now()->toTimeString(),
                'latitude' => $request->input('latitude'),
                'longitude' => $request->input('longitude'),
                'is_valid' => $isValid,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Pointage d\'arrivée enregistré',
            'data' => $presence->fresh(),
        ]);
    }

    public function checkOut(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $validator->errors(),
            ], 422);
        }

        $today = Carbon::today()->toDateString();
        $presence = Presence::where('user_id', $request->user()->id)
            ->where('date', $today)
            ->first();

        if (!$presence) {
            return response()->json([
                'success' => false,
                'message' => 'Aucun pointage d\'arrivée trouvé pour aujourd\'hui',
            ], 404);
        }

        $presence->update([
            'heure_depart' => now()->toTimeString(),
            'latitude' => $request->input('latitude'),
            'longitude' => $request->input('longitude'),
            'is_valid' => $presence->is_valid && $this->isInsidePac(
                (float) $request->input('latitude'),
                (float) $request->input('longitude')
            ),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pointage de départ enregistré',
            'data' => $presence->fresh(),
        ]);
    }

    private function isInsidePac(float $lat, float $lng): bool
    {
        $distance = $this->haversineMeters($lat, $lng, self::PAC_CENTER_LAT, self::PAC_CENTER_LNG);
        return $distance <= self::PAC_RADIUS_METERS;
    }

    private function haversineMeters(float $lat1, float $lon1, float $lat2, float $lon2): float
    {
        $earthRadius = 6371000.0;
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        $a = sin($dLat / 2) ** 2
            + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon / 2) ** 2;
        return $earthRadius * (2 * atan2(sqrt($a), sqrt(1 - $a)));
    }
}
