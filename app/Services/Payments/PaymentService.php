<?php

namespace App\Services\Payments;

use App\Models\Organization;
use App\Models\Payment;
use App\Services\Subcriptions\SubcriptionService;
use Carbon\Carbon;

class PaymentService
{
    private $organizationId;
    private $organization;

    public function __construct(Organization $organization)
    {
        $this->organizationId = $organization->id;
        $this->organization = $organization;
    }

    public function getAll()
    {
        $payments = Payment::with('organization', 'user', 'subcription')
        ->where('organization_id', $this->organizationId)
        ->get();

        return $payments;
    }

    public function getById(int $id)
    {
        $payment = Payment::with('organization', 'user', 'subcription')
        ->where('organization_id', $this->organizationId)
        ->find($id);

        return $payment;
    }

    public function getByFilter(array $filters)
    {
        $payments = Payment::with('organization', 'user', 'subcription')
        ->where('organization_id', $this->organizationId)
        ->where($filters)
        ->get();

        return $payments;
    }

    public function getByBetweenAndUserId(string $startDate, string $endDate, int $userId)
    {
        $payments = Payment::with('organization', 'user', 'subcription')
        ->where('organization_id', $this->organizationId)
        ->where('user_id', $userId)
        ->whereBetween('start_date', [$startDate, $endDate])
        ->first();

        return $payments;
    }

    public function create(array $data)
    {
        $subcriptionService = new SubcriptionService($this->organization);

        $payment = new Payment($data);
        $payment->organization_id = $this->organizationId;

        $subcription = $subcriptionService->getById($data['subcription_id']);

        $days = $subcription->subcriptionDuration->day_durations;

        $startDate = new Carbon($payment->start_date);

        if ($days >= 28 && $days <= 31) {
            $payment->end_date = $startDate->addMonth();
        } elseif ($days >= 181 && $days <= 183) {
            $payment->end_date = $startDate->addMonths(6);
        } elseif ($days >= 364 && $days <= 366) {
            $payment->end_date = $startDate->addYear();
        } else {
            $payment->end_date = $startDate->addDays($days);
        }
        
        $payment->end_date = $payment->end_date->format('Y-m-d');

        $existPayment = $this->getByBetweenAndUserId($payment->start_date, $payment->end_date, $payment->user_id);

        if ($existPayment) {
            return null;
        }

        $payment->save();

        return $payment;
    }

    public function update(int $id, array $data)
    {
        $payment = $this->getById($id);
        
        if (!$payment) {
            return null;
        }
        
        $existPayment = $this->getByBetweenAndUserId($data['start_date'], $data['end_date'], $data['user_id']);

        if ($existPayment && $existPayment->id !== $id) {
            return null;
        }

        $payment->update($data);

        return $payment;
    }

    public function delete(int $id)
    {
        $payment = $this->getById($id);

        if (!$payment) {
            return null;
        }

        $payment->delete();

        return $payment;
    }
}