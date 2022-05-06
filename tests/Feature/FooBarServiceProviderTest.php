<?php

namespace Tests\Feature;

use App\Services\HelloService;
use App\Data\Bar;
use App\Data\Foo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FooBarServiceProviderTest extends TestCase
{
   public function testServiceProvider(){
        $foo1 = $this->app->make(Foo::class);
        $foo2 = $this->app->make(Foo::class);

        self::assertSame($foo1, $foo2);

        $bar1 = $this->app->make(Bar::class);
        $bar2 = $this->app->make(Bar::class);
        
        self::assertSame($bar1, $bar2);

        self::assertSame($bar1->foo, $foo1);
        self::assertSame($bar2->foo, $foo2);
   }

   public function testPropertySingletons(){
       $helloService1 = $this->app->make(HelloService::class);
       $helloService2 = $this->app->make(HelloService::class);

       self::assertSame($helloService1, $helloService2);

       self::assertEquals('Halo mamat', $helloService1->hello('mamat'));
   }
}
