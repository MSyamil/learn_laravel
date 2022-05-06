<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ResponseControllerTest extends TestCase
{
    public function testResponse()
    {
        $this->get('/response/hello')
            ->assertStatus(200)
            ->assertSee('Hello response');
    }

    public function testHeader()
    {
        $this->get('/response/header')
            ->assertStatus(200)
            ->assertSeeText('Ancrit')->assertSeeText('Dek')
            ->assertHeader('Content-Type', 'application/json')
            ->assertHeader('Author', 'nivek')
            ->assertHeader('App', 'learn laravel');
    }
    
    public function testView()
    {
        $this->get('/response/type/view')
            ->assertSeeText('Hello Ancrit'); 
    }

    public function testJson()
    {
        $this->get('/response/type/json')
            ->assertJson([
                'first_name' => 'Ancrit', 
                'last_name' => 'Dek'
            ]);
    }

    public function testFile()
    {
        $this->get('/response/type/file')
            ->assertHeader('Content-Type', 'text/plain');
    }

    public function testDownload()
    {
        $this->get('/response/type/download')
            ->assertDownload('test.txt');
    }
}
