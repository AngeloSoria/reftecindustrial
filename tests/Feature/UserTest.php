<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class UserTest extends TestCase
{
    /**
     *
     * A basic feature test example.
     */
    #[Test]
    public function users_retrieve_all_users(): void
    {
        $response = $this->get('/api/test');

        $response->assertStatus(200);
    }
}
