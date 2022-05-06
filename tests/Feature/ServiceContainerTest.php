<?php

namespace Tests\Feature;

use App\Data\Bar;
use App\Data\Foo;
use App\Data\Person;
use App\Services\HelloService;
use App\Services\HelloServiceIndonesia;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use function PHPUnit\Framework\assertEquals;

class ServiceContainerTest extends TestCase
{
    public function testDependency()
    {
        // $foo = new Foo();
        $foo1 = $this->app->make(Foo::class); // seperti new Foo()
        $foo2 = $this->app->make(Foo::class); // seperti new Foo()
        
        self::assertNotSame($foo1, $foo2);
    }

    public function testBind(){
        // not like these
        // $person = $this->app->make(Person::class);
        // self::assertInstanceOf($person);

        $this->app->bind(Person::class, function($app){
            return new Person('John', 'Doe');
        });

        $person1 = $this->app->make(Person::class); // closure() dan manggil new Person('John', 'Doe')
        $person2 = $this->app->make(Person::class); // closure() dan manggil new Person('John', 'Doe')

        self::assertEquals('John', $person1->firstName);
        self::assertEquals('John', $person2->firstName);
        self::assertNotSame($person1, $person2); //tidak sama 
    }

    public function testSingleton(){
        $this->app->singleton(Person::class, function($app){
            return new Person('John', 'Doe'); // si ini di bikin sekali kalo singleton
        });

        $person1 = $this->app->make(Person::class); // manggil new Person('John', 'Doe'); if not exist
        $person2 = $this->app->make(Person::class); // return existing instance

        self::assertEquals('John', $person1->firstName);
        self::assertEquals('John', $person2->firstName);
        self::assertSame($person1, $person2); // sama 
    }

    public function testInstance(){
        $person = new Person('Mamat', 'Kulon');
        $this->app->instance(Person::class, $person);

        $person1 = $this->app->make(Person::class); // $person
        $person2 = $this->app->make(Person::class); // $person

        self::assertEquals('Mamat', $person1->firstName);
        self::assertEquals('Mamat', $person2->firstName);
        self::assertSame($person1, $person2); // sama 
    }

    public function testDependencyInjection()
    {
        $this->app->singleton(Foo::class, function ($app){
            return new Foo();
        });
        $this->app->singleton(Bar::class, function ($app){
            $foo = $app->make(Foo::class);
            return new Bar($foo);
        });

        $foo = $this->app->make(Foo::class);
        $bar1 = $this->app->make(Bar::class);
        $bar2 = $this->app->make(Bar::class);

        self::assertSame($foo, $bar1->foo);
        self::assertSame($bar1, $bar2);
    }

    public function testInterfaceToClass(){
        // $this->app->singleton(HelloService::class, HelloServiceIndonesia::class);

        $this->app->singleton(HelloService::class, function($app){
            return new HelloServiceIndonesia();
        });

        $helloService = $this->app->make(HelloService::class);

        self::assertEquals('Halo Mamat', $helloService->hello('Mamat'));
    }
}
