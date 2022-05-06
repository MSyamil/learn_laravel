<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RoutingTest extends TestCase
{
    public function testGet()
    {
        $this->get('/hello')
        ->assertStatus(200)
        ->assertSeeText('Hello Ancrit');
    }

    public function testRedirect()
    {
        $this->get('/ancrit')
        ->assertRedirect('/hello');
    }

    public function testFallback()
    {
        $this->get('/notfound')
        ->assertSeeText('Page not found');
    }

    public function testRouteParameter()
    {   
        $this->get('/products/1')
        ->assertSeeText('Product ID: 1');

        $this->get('/products/1/items/2')
        ->assertSeeText('Product: 1, Item: 2');
    }

    public function testRouteParameterRegex()
    {   
        $this->get('/category/1')
        ->assertSeeText('Category ID: 1');

        $this->get('/category/1/items/woi')
        ->assertSeeText('Page not found');
    }

    public function TestRouteParameterOptional()
    {
        $this->get('/users/Limau')
        ->assertSeeText('User Limau');

        $this->get('/users/')
        ->assertSeeText('User 404');
    }

    public function testRouteConflict()
    {
        $this->get('/conflict/budi')
        ->assertSeeText('Conflict budi');

        $this->get('/conflict/niv')
        ->assertSeeText('Conflict niv kaiser');
    }

    public function testNamedRoute()
    {
        $this->get('/produk/12345')
            ->assertSeeText('Link http://127.0.0.1:8000/products/12345');

        $this->get('/produk-redirect/12345')
            ->assertRedirect('/products/12345');
    }
}
