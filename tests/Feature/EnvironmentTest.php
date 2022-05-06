<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Env; 

class EnvironmentTest extends TestCase
{
    public function testGetEnv(){
    $manga = env('ALOK');

    self::assertEquals('Manga Alok Vol 1', $manga);
    }   

    public function testDefaultEnv(){
        $author = Env::get('AUTHOR', 'mamat');
        
        self::assertEquals('mamat', $author);
    }
}
