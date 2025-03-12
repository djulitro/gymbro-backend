<?php

namespace App\Services\Subcriptions;

use App\Models\Organization;
use App\Models\Subcription;
use App\Models\SubcriptionDuration;

class SubcriptionDurationService
{
    private $organizationId;

    public function __construct(Organization $organization)
    {
        $this->organizationId = $organization->id;
    }

    public function getAll()
    {
        $subcriptionDurations = SubcriptionDuration::where('organization_id', $this->organizationId)->get();

        return $subcriptionDurations;
    }


    public function getById(int $id)
    {
        $subcriptionDuration = SubcriptionDuration::where('organization_id', $this->organizationId)->find($id);

        return $subcriptionDuration;
    }

    public function create(array $data)
    {
        $subcriptionDuration = new SubcriptionDuration($data);
        $subcriptionDuration->organization_id = $this->organizationId;

        $subcriptionDuration->save();

        return $subcriptionDuration;
    }

    public function update(int $id, array $data)
    {
        $subcriptionDuration = $this->getById($id);
        
        if (!$subcriptionDuration) {
            return null;
        }

        $subcriptionDuration->update($data);

        return $subcriptionDuration;
    }

    public function delete(int $id)
    {
        $subcriptionDuration = $this->getById($id);

        if (!$subcriptionDuration) {
            return null;
        }

        $subcriptionDuration->delete();

        return $subcriptionDuration;
    }
}