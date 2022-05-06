<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SessionControllerTest extends TestCase
{
    public function testCreateSession()
    {
        $this->get('/session/create')
            ->assertSeeText('Session Created')
            ->assertSessionHas('userId', 'Guwah')
            ->assertSessionHas('isMember', true);
    }

    public function testGetSession()
    {
        $this->withSession([
            'userId' => 'Guwah',
            'isMember' => true
        ])->get('/session/get')
            ->assertSeeText('User ID: Guwah, Is Member: true');
    }

    public function testGetSessionFailed()
    {
        $this->withSession([])->get('/session/get')
            ->assertSeeText('User ID: guest, Is Member: false');
    }

    
}
