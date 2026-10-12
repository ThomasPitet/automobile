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