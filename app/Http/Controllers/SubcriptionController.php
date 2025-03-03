<?php

namespace App\Http\Controllers;

use App\Http\Requests\Subcription\SubcriptionCreateRequest;
use App\Http\Requests\Subcription\SubcriptionUpdateRequest;
use App\Models\Subcription;
use App\Services\Subcriptions\SubcriptionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubcriptionController extends Controller
{
    private SubcriptionService $subcriptionService;

    public function __construct()
    {
        $organization = Auth::user()->organization;
        $this->subcriptionService = new SubcriptionService($organization);
    }

    public function getAll()
    {
        $subcriptions = $this->subcriptionService->getAll();

        return response()->json([
            'message' => 'Subcripciones encontradas.',
            'data' => $subcriptions,
        ]);
    }

    public function getById(int $id)
    {
        $subcription = $this->subcriptionService->getById($id);

        return response()->json([
            'message' => 'Subcripción encontrada.',
            'data' => $subcription,
        ]);
    }

    public function create(SubcriptionCreateRequest $request)
    {
        $subcription = $this->subcriptionService->create($request->safe()->all());

        return response()->json([
            'message' => 'Subcripción creada.',
            'data' => $subcription,
        ]);
    }

    public function update(SubcriptionUpdateRequest $request, int $id)
    {
        $subcription = $this->subcriptionService->update($id, $request->safe()->all());

        if (!$subcription) {
            return response()->json([
                'message' => 'Subcripción no encontrada.',
            ], 404);
        }

        return response()->json([
            'message' => 'Subcripción actualizada.',
            'data' => $subcription,
        ]);
    }

    public function delete(int $id)
    {
        $subcription = $this->subcriptionService->delete($id);

        if (!$subcription) {
            return response()->json([
                'message' => 'Subcripción no encontrada.',
            ], 404);
        }

        return response()->json([
            'message' => 'Subcripción eliminada.',
        ]);
    }
}
