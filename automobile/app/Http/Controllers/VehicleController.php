<?php

namespace App\Http\Controllers;

use App\Services\GlincheApiService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class VehicleController extends Controller
{
    public function index(Request $request, GlincheApiService $service): JsonResponse{
        try {
            $vehicles = $service->getVehicles();
            return response()->json($vehicles);
        } catch (\Throwable){
            return response()->json([
                'message' => 'Impossible de récupérer les véhicules'], 
                500
            );
        }
    }
}
