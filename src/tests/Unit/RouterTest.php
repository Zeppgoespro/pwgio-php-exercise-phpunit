<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Exceptions\RouteNotFoundException;
use App\Router;
use PHPUnit\Framework\TestCase;
use App\Container;

/*

  Given - When - Then
  Arrange - Act - Assert

  Given that we have a router object
  When we call a register method
  Then we assert route was registered

*/

class RouterTest extends TestCase
{
  private Router $router;

  protected function setUp(): void
  {
    parent::setUp();

    $this->router = new Router(new Container());
  }

  /** @test */
  public function test_that_it_registers_a_route(): void # test_
  {
    # Given

    $this->router->register('get', '/users', ['Users', 'index']); # When

    $expected = [
      'get' => [
        '/users' => ['Users', 'index']
      ]
    ];

    $this->assertSame($expected, $this->router->routes()); # Then
  }

  /** @test */
  public function it_registers_a_get_route(): void
  {
    # Given

    $this->router->get('/users', ['Users', 'index']); # When

    $expected = [
      'get' => [
        '/users' => ['Users', 'index']
      ]
    ];

    $this->assertSame($expected, $this->router->routes()); # Then
  }

  /** @test */
  public function it_registers_a_post_route(): void
  {
    # Given

    $this->router->post('/users', ['Users', 'store']); # When

    $expected = [
      'post' => [
        '/users' => ['Users', 'store']
      ]
    ];

    $this->assertSame($expected, $this->router->routes()); # Then
  }

  /** @test */
  public function there_are_no_routes_when_router_is_created(): void
  {
    $router = new Router(new Container());

    $this->assertEmpty($router->routes());
  }

  /**
   * @test
   * @dataProvider \Tests\DataProviders\RouterDataProvider::routeNotFoundCases
  */
  public function it_throws_route_not_found_exception(string $requestUri, string $requestMethod): void
  {
    $users = new class() {
      public function delete(): bool
      {
        return true;
      }
    };

    $this->router->post('/users', [$users::class, 'store']);
    $this->router->get('/users', ['Users', 'index']);

    $this->expectException(RouteNotFoundException::class); # before the exception
    $this->router->resolve($requestUri, $requestMethod);
  }

  /** @test */
  public function it_resolves_route_from_a_closure(): void
  {
    $this->router->get('/users', fn() => [1, 2, 3]);
    $this->assertSame([1, 2, 3], $this->router->resolve('/users', 'get'));
  }

  /** @test */
  public function it_resolves_route(): void
  {
    $users = new class() {
      public function index(): array
      {
        return ['1',2,3]; # Caution
      }
    };

    $this->router->get('/users', [$users::class, 'index']);

    $this->assertEquals([1,2,3], $this->router->resolve('/users', 'get')); # Everytime loose comparison, better to use assertSame()
  }
}