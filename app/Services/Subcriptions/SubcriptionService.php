<?php

namespace App\Services\Subcriptions;

use App\Models\Organization;
use App\Models\Subcription;
use App\Models\Payment;
use Carbon\Carbon;

class SubcriptionService
{
    private $organizationId;

    public function __construct(Organization $organization)
    {
        $this->organizationId = $organization->id;
    }

    public function getAll()
    {
        $subcriptions = Subcription::with('subcriptionDuration')
        ->where('organization_id', $this->organizationId)
        ->get();

        return $subcriptions;
    }

    public function getById(int $id)
    {
        $subcription = Subcription::with('subcriptionDuration')
        ->where('organization_id', $this->organizationId)
        ->find($id);

        return $subcription;
    }

    public function getActiveSubcription(int $userId)
    {
        $now = Carbon::now()->format('Y-m-d');

        $subcription = Payment::with('subcription')
        ->where('organization_id', $this->organizationId)
        ->where('user_id', $userId)
        ->where('start_date', '<=', $now)
        ->where('end_date', '>=', $now)
        ->first();

        return $subcription;
    }

    public function create(array $data)
    {
        $data['organization_id'] = $this->organizationId;
        $subcription = Subcription::create($data);

        return $subcription;
    }

    public function update(int $id, array $data)
    {
        $subcription = $this->getById($id);
        
        if (!$subcription) {
            return null;
        }

        $subcription->update($data);

        return $subcription;
    }

    public function delete(int $id)
    {
        $subcription = $this->getById($id);

        if (!$subcription) {
            return null;
        }

        $subcription->delete();

        return $subcription;
    }
}