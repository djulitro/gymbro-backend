<?php

namespace App\Services\Punches;

use App\Constants\UserTypeConst;
use App\Models\Organization;
use App\Models\Punch;
use App\Models\User;
use App\Services\Subcriptions\SubcriptionService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PunchService
{
    private $organizationId;

    public function __construct(Organization $organization)
    {
        $this->organizationId = $organization->id;
    }

    public function getAll()
    {
        $punches = Punch::with('organization', 'user', 'subcription')
        ->where('organization_id', $this->organizationId)
        ->get();

        return $punches;
    }

    public function getById($id)
    {
        $punch = Punch::with('organization', 'user', 'subcription')
        ->where('organization_id', $this->organizationId)
        ->where('id', $id)
        ->first();

        return $punch;
    }

    public function create($data)
    {
        $user = Auth::user();

        $subcriptionService = new SubcriptionService(Organization::where('id', $this->organizationId)->first());
        $subcription = $subcriptionService->getActiveSubcription($user->id);

        if ($user->user_type_id !== UserTypeConst::CLIENT) {
            throw new \Exception('Only client can punch'); 
        }

        if (!$subcription) {
            throw new \Exception('No active subcription found');
        }

        $punch = new Punch();
        $punch->organization_id = $this->organizationId;
        $punch->user_id = $user->id;
        $punch->punch_type_id = $data['punch_type_id'];
        $punch->punch = Carbon::now()->format('Y-m-d H:i:s');

        $punch->save();

        return $punch;
    }

    public function confirmAdmin($id, $adminId)
    {
        $punch = Punch::where('organization_id', $this->organizationId)
        ->where('id', $id)
        ->first();

        if (!$punch) {
            throw new \Exception('Punch not found');
        }

        $punch->confirm_admin_id = $adminId;
        $punch->save();

        return $punch;
    }
}