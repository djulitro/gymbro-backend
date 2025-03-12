<?php

namespace App\Http\Controllers;

use App\Http\Requests\Subcription\SubcriptionDurationCreateRequest;
use App\Http\Requests\Subcription\SubcriptionDurationUpdateRequest;
use App\Models\Organization;
use App\Services\Subcriptions\SubcriptionDurationService;
use Illuminate\Support\Facades\Auth;

class SubcriptionDurationController extends Controller
{
    private Organization $organization;

    public function __construct()
    {
        $this->organization = Auth::user()->organization;
    }

    public function getAll()
    {
        $subcriptionDurationService = new SubcriptionDurationService($this->organization);

        $subcriptionDurations = $subcriptionDurationService->getAll();

        return response()->json([
            'message' => 'Duraciones de subcripciones encontradas.',
            'data' => $subcriptionDurations,
        ]);
    }

    public function getById(int $id)
    {
        $subcriptionDurationService = new SubcriptionDurationService($this->organization);

        $subcriptionDuration = $subcriptionDurationService->getById($id);

        return response()->json([
            'message' => 'Duración de subcripción encontrada.',
            'data' => $subcriptionDuration,
        ]);
    }

    public function create(SubcriptionDurationCreateRequest $request)
    {
        $subcriptionDurationService = new SubcriptionDurationService($this->organization);

        $subcriptionDuration = $subcriptionDurationService->create($request->safe()->all());

        return response()->json([
            'message' => 'Duración de subcripción creada.',
            'data' => $subcriptionDuration,
        ]);
    }

    public function update(SubcriptionDurationUpdateRequest $request, int $id)
    {
        $subcriptionDurationService = new SubcriptionDurationService($this->organization);

        $subcriptionDuration = $subcriptionDurationService->update($id, $request->safe()->all());

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
        $subcriptionDurationService = new SubcriptionDurationService($this->organization);

        $subcriptionDuration = $subcriptionDurationService->delete($id);

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
