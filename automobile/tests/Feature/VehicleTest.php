<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class VehicleTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Cache::flush();
    }
        public function testHome(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Glinche Automobiles - Catalogue');
    }

    public function testApiVehiclesList(): void
    {
        $fakeVehicles = [
            [
                'reference' => 'GLI12345',
                'vehicle' => [
                    'manufacturer' => 'Peugeot',
                    'model' => '208',
                    'finish' => 'Active',
                    'prices' => ['merchantPrice' => '15000'],
                    'mileage' => 12000,
                    'year' => 2021,
                    'energy' => 'ES',
                ],
                'pictures' => [
                    ['url' => 'https://example.com/car.jpg']
                ],
            ]
        ];

        Http::fake([
            '*/login' => Http::response(['token' => 'fake-jwt-token'], 200),
            '*/vehicles' => Http::response($fakeVehicles, 200),
        ]);

        $response = $this->getJson('/api/vehicles');

        $response->assertStatus(200)
            ->assertJson($fakeVehicles);
    }
    
    public function testToken(): void
    {
        Http::fake([
            '*/login' => Http::response(['token' => 'cached-test-token'], 200),
            '*/vehicles' => Http::response([], 200),
        ]);

        $this->getJson('/api/vehicles')->assertStatus(200);
        $this->getJson('/api/vehicles')->assertStatus(200);
        
        Http::assertSent(function ($request) {
            return str_contains($request->url(), '/login');
        }, 1);
    }