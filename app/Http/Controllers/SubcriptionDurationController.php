<?php

namespace App\Http\Controllers;

use App\Http\Requests\Subcription\SubcriptionDurationCreateRequest;
use App\Http\Requests\Subcription\SubcriptionDurationUpdateRequest;
use App\Services\Subcriptions\SubcriptionDurationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubcriptionDurationController extends Controller
{
    private SubcriptionDurationService $subcriptionDurationService;

    public function __construct()
    {
        $organization = Auth::user()->organization;
        $this->subcriptionDurationService = new SubcriptionDurationService($organization);
    }

    public function getAll()
    {
        $subcriptionDurations = $this->subcriptionDurationService->getAll();

        return response()->json([
            'message' => 'Duraciones de subcripciones encontradas.',
            'data' => $subcriptionDurations,
        ]);
    }

    public function getById(int $id)
    {
        $subcriptionDuration = $this->subcriptionDurationService->getById($id);

        return response()->json([
            'message' => 'Duración de subcripción encontrada.',
            'data' => $subcriptionDuration,
        ]);
    }

    public function create(SubcriptionDurationCreateRequest $request)
    {
        $subcriptionDuration = $this->subcriptionDurationService->create($request->safe()->all());

        return response()->json([
            'message' => 'Duración de subcripción creada.',
            'data' => $subcriptionDuration,
        ]);
    }

    public function update(SubcriptionDurationUpdateRequest $request, int $id)
    {
        $subcriptionDuration = $this->subcriptionDurationService->update($id, $request->safe()->all());

        if (!$subcriptionDuration) {
            return response()->json([
                'message' => 'Duración de subcripción no encontrada.',
            ], 404);
        }

        return response()->json([
            'message' => 'Duración de subcripción actualizada.',
            'data' => $subcriptionDuration,
        ]);
    }

    public function delete(int $id)
    {
        $subcriptionDuration = $this->subcriptionDurationService->delete($id);

        if (!$subcriptionDuration) {
            return response()->json([
                'message' => 'Duración de subcripción no encontrada.',
            ], 404);
        }

        return response()->json([
            'message' => 'Duración de subcripción eliminada.',
            'data' => $subcriptionDuration,
        ]);
    }
}
