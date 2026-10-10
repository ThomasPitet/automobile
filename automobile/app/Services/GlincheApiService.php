<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Exception;

class GlincheApiService {
    public function getToken(): string {
        
        return Cache::remember('glinche_token', now()->addHour(1), function() {
        
        $response = Http::post(config('services.glinche.url') . '/login', [
            'email' => config('services.glinche.email'),
            'password' => config('services.glinche.password'),
        ]);

        if($response->successful()){
            $data = $response->json();
            return $data['token'];
        }else{
            throw new Exception('Erreur de connexion');
        }
        });
    }
    }
