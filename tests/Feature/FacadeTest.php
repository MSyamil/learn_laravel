<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class FacadeTest extends TestCase
{
    public function testConfig(){
        $firstName1 = config('contoh.person.first_name');
        $firstName2 = Config::get('contoh.person.first_name');

        self::assertEquals($firstName1, $firstName2);

        var_dump(Config::all());
    }

    public function testConfigDependency(){
        $config = $this->app->make('config'); // same as Config::get()
        $firstName3 = $config->get('contoh.person.first_name');

        $firstName1 = config('contoh.person.first_name');
        $firstName2 = Config::get('contoh.person.first_name');

        self::assertEquals($firstName1, $firstName2);
        self::assertEquals($firstName1, $firstName3);
        

        // var_dump(Config::all());
        // same as
        // var_dump($config->all());
    }

    public function testFacadeMock(){
        Config::shouldReceive('get')
            ->with('contoh.person.first_name')
            ->andReturn('Niv');

        $firstName = Config::get('contoh.person.first_name');

        self::assertEquals('Niv', $firstName);
    }
}
