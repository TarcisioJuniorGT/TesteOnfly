<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Tests\TestCase;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class ExpenseTest extends TestCase
{
    use RefreshDatabase;
    use HasFactory;

    public function testExpenseRouteRequiresAuthentication()
    {
        $response = $this->get('/api/expenses');
        $response->assertStatus(401);
    }

    public function testExpenseRouteIsAccessibleWithAuthentication()
    {
        $user = User::factory(User::class)->create();
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('/api/expenses');

        $response->assertStatus(200);
    }

    public function testStore()
    {
        $user = User::factory(User::class)->create();
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->post('/api/expenses', [
            'id_user' => $user->id,
            'value' => 19.50,
            'date' => '2023-04-02',
            'email' => $user->email,
            'description' => 'This is an example resource.',
        ]);
        $response->assertStatus(200);

        $this->assertDatabaseHas('expenses', [
            'id_user' => $user->id,
            'value' => 19.50,
            'date' => '2023-04-02',
            'email' => $user->email,
            'description' => 'This is an example resource.',
        ]);
    }
}
