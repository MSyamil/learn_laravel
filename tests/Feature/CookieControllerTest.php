<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CookieControllerTest extends TestCase
{
    public function testCreateCookie()
    {
        $this->get('/cookie/set')
            ->assertSeeText('Cookie Created')
            ->assertCookie('User-Id', 'Ancrit') 
            ->assertCookie('Is-Member', true);
    }

    public function testGetCookie()
    {
        $this->withCookie('User-Id', 'Ancrit')
            ->withCookie('Is-Member', true)
            ->get('/cookie/get')
            ->assertJson([
                'User-Id' => 'Ancrit',
                'Is-Member' => true,
            ]);
    }
}
