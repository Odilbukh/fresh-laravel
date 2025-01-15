<?php

namespace Tests\Feature;

use App\Models\Hotel;
use Tests\TestCase;

class HotelTest extends TestCase
{
    protected $token;

    public function setUp(): void
    {
        parent::setUp();

        $login = $this->post('api/login', [
            'email' => 'odil.bukh@gmail.com',
            'password' => '123456'
        ]);

        $this->token = $login->getContent();
    }


    public function testGetHotelById()
    {
        $hotel = Hotel::factory()->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->get('/api/hotels/' . $hotel->id);

        $response->assertStatus(200);
        $this->assertEquals($hotel->name, $response->json('name'));
        $this->assertEquals($hotel->id, $response->json('id'));
    }

    public function testFakeGetHotelById()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->get('/api/hotels/' . 99999999);

        $response->assertStatus(404);
    }

    public function testDeleteHotel()
    {
        $hotel = Hotel::factory()->create();
        $this->assertDatabaseHas('hotels', ['id' => $hotel->id]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->delete('/api/hotels/' . $hotel->id);

        $response->assertStatus(200);
        $this->assertDatabaseMissing('hotels', ['id' => $hotel->id]);
    }

    public function testGetHotels()
    {
        Hotel::factory()->count(10)->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->get('/api/hotels?page=2&perPage=5');

        $response->assertStatus(200)->assertJsonCount(5, 'data')->assertJson([
            'current_page' => 2,
            'from' => 6,
            'to' => 10,
            'per_page' => 5,
        ]);
    }

    public function testSearchByHotelName()
    {
        Hotel::factory()->count(1)->create([
            'name' => 'TestHotel'
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->get('/api/hotels?page=1&perPage=5&name=TestHotel');

        $response->assertStatus(200)->assertJsonFragment([
            'name' => 'TestHotel'
        ]);
    }

    public function testSearchByHotelFakeName()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->get('/api/hotels?page=1&perPage=5&name=FakeName');

        $response->assertStatus(200)->assertJsonCount(0, 'data');
    }

    public function testSearchByHotelCity()
    {
        Hotel::factory()->count(1)->create([
            'city' => 'Bostan'
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->get('/api/hotels?page=1&perPage=5&city=Bostan');

        $response->assertStatus(200)->assertJsonFragment([
            'city' => 'Bostan'
        ]);
    }

    public function testSearchByHotelFakeCity()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->get('/api/hotels?page=1&perPage=5&city=FakeCity');

        $response->assertStatus(200)->assertJsonCount(0, 'data');
    }

    public function testCreateHotel()
    {
        $data = [
            'name' => 'Test Create Hotel',
            'city' => 'Bostan',
            'address' => 'Test Address',
            'description' => 'This is a test hotel',
            ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->post('/api/hotels', $data);

        $response->assertStatus(200)->assertJson(["message" => "Hotel created successfully"]);
        $this->assertDatabaseHas('hotels', $data);
    }

    public function testCreateHotelWithFail()
    {
        $data = [
            'city' => 'Bostan',
            'address' => 'Test Address',
            'description' => 'This is a test hotel',
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
            'Accept' => 'application/json',
        ])->post('/api/hotels', $data);

        $response->assertStatus(422);
        $response->assertJson(["message" => "The name field is required."]);
        $response->assertJsonValidationErrors(['name']);
    }
}