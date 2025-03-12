<?php

namespace App\Http\Controllers;

use App\Http\Requests\Punches\PunchCreateRequest;
use App\Services\Punches\PunchService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PunchController extends Controller
{
    private PunchService $punchService;

    public function __construct()
    {
        $organization = Auth::user()->organization;
        $this->punchService = new PunchService($organization);
    }

    public function getAll()
    {
        $punches = $this->punchService->getAll();

        return response()->json([
            'message' => 'Punches found.',
            'data' => $punches,
        ]);
    }

    public function getById(int $id)
    {
        $punch = $this->punchService->getById($id);

        return response()->json([
            'message' => 'Punch found.',
            'data' => $punch,
        ]);
    }

    public function create(PunchCreateRequest $request)
    {
        $data = $request->safe()->all();
        $punch = $this->punchService->create($data);

        return response()->json([
            'message' => 'Punch created.',
            'data' => $punch,
        ]);
    }

    public function confirmAdmin(int $punchId)
    {
        $adminId = Auth::user()->id;
        $punch = $this->punchService->confirmAdmin($punchId, $adminId);

        return response()->json([
            'message' => 'Punch confirmed.',
            'data' => $punch,
        ]);
    }
}
