<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Activite;
use App\Models\AffectationStage;
use App\Models\Departement;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminController extends Controller
{
    public function createDepartement(Request $request): JsonResponse
    {
        $this->assertAdmin($request);

        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:255|unique:departements,nom',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $dep = Departement::create($validator->validated());
        return response()->json(['success' => true, 'data' => $dep], 201);
    }

    public function listDepartements(Request $request): JsonResponse
    {
        $this->assertAdmin($request);
        return response()->json(['success' => true, 'data' => Departement::orderBy('nom')->get()]);
    }

    public function assignStagiaire(Request $request): JsonResponse
    {
        $this->assertAdmin($request);

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'departement_id' => 'required|exists:departements,id',
            'maitre_stage_id' => 'nullable|exists:users,id',
            'date_debut' => 'nullable|date',
            'date_fin' => 'nullable|date|after_or_equal:date_debut',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $payload = $validator->validated();
        $affectation = AffectationStage::updateOrCreate(
            ['user_id' => $payload['user_id']],
            $payload
        );

        return response()->json([
            'success' => true,
            'message' => 'Affectation enregistrée',
            'data' => $affectation->load(['stagiaire', 'departement', 'maitreStage']),
        ]);
    }

    public function exportStagiairesReport(Request $request): StreamedResponse
    {
        $this->assertAdmin($request);

        $fileName = 'rapport_stagiaires_' . now()->format('Ymd_His') . '.csv';
        $rows = User::where('role', 'stagiaire')->with('affectations.departement')->get();

        return response()->streamDownload(function () use ($rows) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['id', 'nom', 'email', 'departement', 'activites', 'activites_validees']);

            foreach ($rows as $user) {
                $departement = optional(optional($user->affectations->first())->departement)->nom ?? '';
                $activites = Activite::where('user_id', $user->id)->count();
                $valides = Activite::where('user_id', $user->id)->where('statut', 'validee')->count();
                fputcsv($handle, [$user->id, $user->name, $user->email, $departement, $activites, $valides]);
            }
            fclose($handle);
        }, $fileName, ['Content-Type' => 'text/csv']);
    }

    private function assertAdmin(Request $request): void
    {
        abort_unless(in_array($request->user()->role, ['admin', 'maitre'], true), 403, 'Action non autorisée');
    }
}
