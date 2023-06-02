<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Container;
use App\Services\SalesTaxService;
use App\Services\EmailService;
use Tests\Unit\Uninstantiable;
use Tests\Unit\WithoutParameters;
use App\Exceptions\Container\ContainerException;
use PHPUnit\Framework\TestCase;

class ContainerTest extends TestCase
{

  private Container $container;

  protected function setUp(): void
  {
    parent::setUp();

    $this->container = new Container();
  }

  /** @test */
  public function test_get_method_returns_an_instance_of_class(): void
  {
    # Given

    $instance = $this->container->get('App\Services\SalesTaxService'); # When

    $expected = SalesTaxService::class;

    $this->assertInstanceOf($expected, $instance); # Then
  }

  /** @test */
  public function test_get_method_returns_an_instance_of_class_again(): void
  {
    # Given

    $expected = SalesTaxService::class;

    # When

    $instance = $this->container->get($expected);

    # Then

    $this->assertInstanceOf($expected, $instance);
  }

  /** @test */
  public function test_has_method_checks_the_entries_array(): void
  {
    # Given

    $this->container->set('bingo', SalesTaxService::class);

    # When

    $boolTrue = $this->container->has('bingo');

    # Then

    $this->assertSame(true, $boolTrue);

  }

  /** @test */
  public function test_set_method_sets_entry_in_container(): void
  {
    # Given

    $id = 'some_id';
    $concrete = SalesTaxService::class;

    # When

    $this->container->set($id, $concrete);

    # Then

    $this->assertInstanceOf($concrete, $this->container->get($id));

  }

  /** @test */
  public function test_that_resolve_method_throws_exception_if_id_not_instantiable(): void
  {
    $this->expectException(ContainerException::class);
    $this->container->resolve(Uninstantiable::class);
  }

  /** @test */
  public function test_that_resolve_method_returns_new_instance_when_id_has_no_constructor(): void
  {
    # Given
    $instance = $this->container->resolve(EmailService::class);
    # When
    $expected = EmailService::class;
    # Then
    $this->assertInstanceOf($expected, $instance);
  }

  /** @test */
  public function test_that_resolve_method_returns_new_instance_when_id_has_no_parameters(): void
  {
    # Given
    $instance = $this->container->resolve(WithoutParameters::class);
    # When
    $expected = WithoutParameters::class;
    # Then
    $this->assertInstanceOf($expected, $instance);
  }

  /**
   * @test
   * @dataProvider \Tests\DataProviders\ContainerDataProvider::resolveTypeCases
   */
  public function test_that_type_conditionals_of_resolve_method_throws_exceptions(string $id): void
  {
    $this->expectException(ContainerException::class);
    $this->container->resolve($id);
  }
}