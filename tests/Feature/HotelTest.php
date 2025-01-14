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

}