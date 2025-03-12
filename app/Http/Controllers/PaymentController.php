<?php

namespace App\Http\Controllers;

use App\Constants\UserTypeConst;
use App\Http\Requests\Payment\PaymentCreateRequest;
use App\Http\Requests\Payment\PaymentUpdateRequest;
use App\Models\User;
use App\Services\Payments\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    private PaymentService $paymentService;

    public function __construct()
    {
        $organization = Auth::user()->organization;
        $this->paymentService = new PaymentService($organization);
    }

    public function getAll()
    {
        $payments = $this->paymentService->getAll();

        return response()->json([
            'message' => 'Pagos encontrados.',
            'data' => $payments,
        ]);
    }

    public function getByDates(string $startDate, string $endDate)
    {
        $payments = $this->paymentService->getByFilter([
            ['start_date', '>=', $startDate],
            ['end_date', '<=', $endDate],
        ]);

        return response()->json([
            'message' => 'Pagos encontrados.',
            'data' => $payments,
        ]);
    }

    public function getById(int $id)
    {
        $payment = $this->paymentService->getById($id);

        if (!$payment) {
            return response()->json([
                'message' => 'Pago no encontrado.',
            ], 404);
        }

        return response()->json([
            'message' => 'Pago encontrado.',
            'data' => $payment,
        ]);
    }

    public function create(PaymentCreateRequest $request)
    {
        // Necesito validar que el usuario sea un cliente y no un administrador
        $data = $request->safe()->all();

        $user = User::where('id', $data['user_id'])->first();

        if ($user->user_type_id !== UserTypeConst::CLIENT) {
            return response()->json([
                'message' => 'El usuario debe ser un cliente.',
            ], 400);
        }

        $payment = $this->paymentService->create($data);

        if (!$payment) {
            return response()->json([
                'message' => 'Error al crear el pago.',
            ], 400);
        }

        return response()->json([
            'message' => 'Pago creado.',
            'data' => $payment,
        ], 201);
    }

    public function update(int $id, PaymentUpdateRequest $request)
    {
        $payment = $this->paymentService->update($id, $request->safe()->all());

        if (!$payment) {
            return response()->json([
                'message' => 'Pago no encontrado.',
            ], 404);
        }

        return response()->json([
            'message' => 'Pago actualizado.',
            'data' => $payment,
        ]);
    }

    public function delete(int $id)
    {
        $payment = $this->paymentService->delete($id);

        if (!$payment) {
            return response()->json([
                'message' => 'Pago no encontrado.',
            ], 404);
        }

        return response()->json([
            'message' => 'Pago eliminado.',
            'data' => $payment,
        ]);
    }
}
