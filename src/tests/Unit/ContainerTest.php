<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Container;
use App\Services\SalesTaxService;
use App\Services\EmailService;
use App\Services\PaymentGatewayService;
use Tests\Unit\TestingInvoiceService;
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
    $expected = SalesTaxService::class; # Given

    $instance = $this->container->get('App\Services\SalesTaxService'); # When

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

    # When

    $this->container->set('bingo', SalesTaxService::class);
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

    $expected = EmailService::class;

    # When

    $instance = $this->container->resolve(EmailService::class);

    # Then

    $this->assertInstanceOf($expected, $instance);
  }

  /** @test */
  public function test_that_resolve_method_returns_new_instance_when_id_has_no_parameters(): void
  {
    # Given

    $expected = WithoutParameters::class;

    # When

    $instance = $this->container->resolve(WithoutParameters::class);

    # Then

    $this->assertInstanceOf($expected, $instance);
  }

  /**
   * @test
   * @dataProvider \Tests\DataProviders\ContainerDataProvider::resolveTypeCases
   */
  public function test_that_type_conditionals_of_resolve_method_throws_exceptions($id): void
  {
    $this->expectException(ContainerException::class);
    $this->container->resolve($id);
  }

  /** @test */
  public function test_resolve_method_returns_dependency_for_named_type(): void
  {
    # Given

    # When

    $invoiceService = $this->container->resolve(TestingInvoiceService::class);

    # Then

    $this->assertInstanceOf(SalesTaxService::class, $invoiceService->sales_tax_service);
    $this->assertInstanceOf(PaymentGatewayService::class, $invoiceService->gateway_service);
    $this->assertInstanceOf(EmailService::class, $invoiceService->email_service);
  }

}