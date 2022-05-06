<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ContohMiddlewareTest extends TestCase
{
    public function testMiddlewareInvalid()
    {
        $this->get('/middleware/api')
            ->assertStatus(401)
            ->assertJson([
                'error' => 'Unauthorized'
            ]);
    }

    public function testMiddlewareValid()
    {
        $this->withHeader('X-API-KEY', 'guwah')
            ->get('/middleware/api')
            ->assertStatus(200)
            ->assertSeeText('Hello World');
    }

    public function testMiddlewareInvalidGroup()
    {
        $this->get('/middleware/group') 
        ->assertStatus(401)
        ->assertJson([
            'error' => 'Unauthorized'
        ]);
    }

    public function testMiddlewareValidGroup()
    {
        $this->withHeader('X-API-KEY', 'guwah')
            ->get('/middleware/group')
            ->assertStatus(200)
            ->assertSeeText('Hello Group');
    }
}
