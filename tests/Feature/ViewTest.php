<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ViewTest extends TestCase
{
    public function testView(){
        $this->get('/hello')
        ->assertSeeText('Hello Ancrit');

        $this->get('/hello-again')
        ->assertSeeText('Hello Dek');
    }

    public function testNested(){
        $this->get('/beliau')
        ->assertSeeText('Ancrit beliau ni Kamal');
    }

    public function testTemplate(){
        $this->view('hello', ['name' => 'Niv'])
        ->assertSeeText('Hello Niv');

        $this->view('lapar.nich', ['name' => 'Niv'])
        ->assertSeeText('Ancrit beliau ni Niv');
    }
}
