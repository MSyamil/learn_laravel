<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InputControllerTest extends TestCase
{
    public function testInput()
    {
        $this->get('/input/hello?name=nivek')
        ->assertSeeText('Hello nivek');

        $this->post('/input/hello', [
            'name' => 'nivek'
        ])->assertSeeText('Hello nivek');
    }

    public function testInputFirstName()
    {
        $this->post('/input/hello/first', [
            "name" => [
                "first" => "nivek",
                "last" => "kaiser"
            ]
        ])->assertSeeText('Hello nivek');
    }

    public function testInputAll()
    {
        $this->post('/input/hello/input', [
            "name" => [
                "first" => "nivek",
                "last" => "kaiser"
            ]
        ])->assertSeeText('name')->assertSeeText('first')
            ->assertSeeText('last')->assertSeeText('nivek')
            ->assertSeeText('kaiser');
    }

    public function testInputArrray()
    {
        $this->post('/input/hello/array', [
            "products" => [
                [
                    "name"=>"Banana Mac Book Pro",
                    "price"=>"$1,000,000"
                ],
                [
                    "name"=>"baygon",
                    "price"=>"$5,000,000"
                ]
            ]
        ])->assertSeeText('Banana Mac Book Pro')
            ->assertSeeText('baygon');
    }

    //input type test

    public function testInputType()
    {
        $this->post('/input/type', [
            "name" => "ahok",
            "developer" => true,
            "birth_date" => "1945-01-01"
        ])->assertSeeText('ahok')->assertSeeText('true')
            ->assertSeeText('1945-01-01');
    }

    //filter request input

    public function testFilterOnly()
    {
        $this->post('/input/filter/only', [
            "name" => [
                "first" => "Fauzan",
                "middle" => "Beliau",
                "last" => "Yardan"
            ]
        ])->assertSeeText('Fauzan')->assertSeeText('Yardan')
            ->assertDontSeeText('Beliau');
    }

    public function testFilterExcept()
    {
        $this->post('/input/filter/except', [
            "username" => "fauzan",
            "password" => "12345",
            "admin" => true
        ])->assertSeeText('fauzan')->assertSeeText('12345')
            ->assertDontSeeText('true');
    }
    
    public function testFilterMerge()
    {
        $this->post('/input/filter/merge', [
            "username" => "fauzan",
            "password" => "12345",
            "admin" => true
        ])->assertSeeText('fauzan')->assertSeeText('12345')
            ->assertSeeText('admin')->assertSeeText('false');
    }
}
