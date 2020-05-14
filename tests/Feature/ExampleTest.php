<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function testGetProperties()
    {
        $this->seed();
        $response = $this->getJson('/api/properties');
        $response->assertStatus(200);
        $response->assertJsonCount(100);
    }

    public function testGetAnalytics()
    {
        $this->seed();
        $response = $this->getJson('/api/analytics');
        $response->assertStatus(200);
        $response->assertJsonCount(3);
    }

    public function testAddProperty()
    {
        $data = ['guid' => '1234', 'suburb' => 'Sydney', 'state' => 'NSW', 'country' => 'Australia'];
        $response = $this->postJson('/api/properties', $data);
        $response->assertStatus(201);
    }

    public function testAddPropertyInvalidInput()
    {
        $data = ['suburb' => 'Sydney', 'state' => 'NSW', 'country' => 'Australia'];
        $response = $this->postJson('/api/properties', $data);
        $response->assertStatus(400);
    }

    public function testAddAnalyticToProperty()
    {
        $this->seed();
        $data = ['value' => 100];
        $url = '/api/properties/1/analytics/1';
        $response = $this->postJson($url, $data);
        $response->assertStatus(200);
    }

    public function testAddAnalyticToPropertyInvalidInput()
    {
        $this->seed();
        $data = ['key' => 100];
        $url = '/api/properties/1/analytics/1';
        $response = $this->postJson($url, $data);
        $response->assertStatus(400);
    }
}
