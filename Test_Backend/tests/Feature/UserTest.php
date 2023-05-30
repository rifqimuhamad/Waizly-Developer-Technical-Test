<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function testRegister()
    {
        $input = [
            'name' => 'Muhamad Rifqi',
            'email' => 'gmail@muhamadrifqi.com',
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
        ];

        $response = $this->postJson('/api/register', $input);

        $response->assertStatus(201);
        $response->assertJson(['success' => true]);

        $this->assertDatabaseHas('users', [
            'email' => 'gmail@muhamadrifqi.com'
        ]);
                $user = User::where('email', 'gmail@muhamadrifqi.com')->first();
        $this->assertNull($user->token);
    }

    public function testLogin()
    {
        // Membuat user baru untuk login
        $user = User::create([
            'name' => 'Muhamad Rifqi',
            'email' => 'gmail@muhamadrifqi.com',
            'password' => Hash::make('secret123'),
        ]);

        $input = [
            'email' => 'gmail@muhamadrifqi.com',
            'password' => 'secret123',
        ];
        $response = $this->postJson('/api/login', $input);
        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
        $user = User::where('email', 'gmail@muhamadrifqi.com')->first();
        $this->assertNotNull($user->token);
    }

    public function testLogout()
    {
        $user = User::factory()->create();
        $token = $user->createToken('api_token')->plainTextToken;
        $headers = ['Authorization' => 'Bearer ' . $token];
        $response = $this->postJson('/api/logout', [], $headers);
        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
        $user->refresh();
        $this->assertNull($user->token);
    }
}
