<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Activite;
use App\Models\Presence;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function summary(Request $request): JsonResponse
    {
        $user = $request->user();

        if ($user->role === 'stagiaire') {
            return response()->json([
                'success' => true,
                'data' => [
                    'my_presences' => Presence::where('user_id', $user->id)->count(),
                    'my_activites' => Activite::where('user_id', $user->id)->count(),
                    'my_activites_validees' => Activite::where('user_id', $user->id)->where('statut', 'validee')->count(),
                ],
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'users_total' => User::count(),
                'stagiaires_total' => User::where('role', 'stagiaire')->count(),
                'presences_today' => Presence::whereDate('date', now()->toDateString())->count(),
                'activites_total' => Activite::count(),
                'activites_soumises' => Activite::where('statut', 'soumise')->count(),
                'activites_validees' => Activite::where('statut', 'validee')->count(),
            ],
        ]);
    }
}
