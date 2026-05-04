<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Activite;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ActiviteController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Activite::with(['user', 'validatedBy'])->orderByDesc('date');

        if ($request->user()->role === 'stagiaire') {
            $query->where('user_id', $request->user()->id);
        }

        return response()->json([
            'success' => true,
            'data' => $query->get(),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required|date',
            'titre' => 'required|string|max:255',
            'description' => 'required|string|max:5000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $validator->errors(),
            ], 422);
        }

        $activite = Activite::create([
            'user_id' => $request->user()->id,
            'date' => $request->input('date'),
            'titre' => $request->input('titre'),
            'description' => $request->input('description'),
            'statut' => 'soumise',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Activité enregistrée',
            'data' => $activite,
        ], 201);
    }

    public function approve(Request $request, Activite $activite): JsonResponse
    {
        if (!in_array($request->user()->role, ['maitre', 'admin'], true)) {
            return response()->json([
                'success' => false,
                'message' => 'Action non autorisée',
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'statut' => 'required|in:validee,rejetee',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $validator->errors(),
            ], 422);
        }

        $activite->update([
            'statut' => $request->input('statut'),
            'validated_by' => $request->user()->id,
            'validated_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Activité mise à jour',
            'data' => $activite->fresh(['user', 'validatedBy']),
        ]);
    }
}
