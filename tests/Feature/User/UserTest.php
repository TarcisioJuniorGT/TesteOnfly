<?php

namespace Tests\Feature\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;
    use HasFactory;

    public function testUserUpdateRouteRequiresAuthentication()
    {
        $response = $this->put('/api/users/1');
        $response->assertStatus(401);
    }
}
