<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use PHPUnit\Framework\TestCase;
use App\Services\InvoiceService;
use App\Services\SalesTaxService;
use App\Services\PaymentGatewayService;
use App\Services\EmailService;

class InvoiceServiceTest extends TestCase
{

  /**
   * @test
   */
  public function it_processes_invoice(): void
  {
    $sales_tax_service_mock = $this->createMock(SalesTaxService::class); # always returns NULL or typehinted
    $gateway_service_mock = $this->createMock(PaymentGatewayService::class); # MOCK THE TEST DOUBLE
    $email_service_mock = $this->createMock(EmailService::class); # MOCK THE TEST DOUBLE

    $gateway_service_mock->method('charge')->willReturn(true); # STUB

    # Given Invoice Service
    $invoice_service = new InvoiceService($sales_tax_service_mock, $gateway_service_mock, $email_service_mock);

    $customer = ['name' => 'Zepp'];
    $amount = 150;
    # When process is called
    $result = $invoice_service->process($customer, $amount);
    # Then assert invoice is processed successfully
    $this->assertTrue($result);
  }

  /**
   * @test
   */
  public function it_sends_receipt_email_when_invoice_is_processed(): void
  {
    $sales_tax_service_mock = $this->createMock(SalesTaxService::class); # always returns NULL or typehinted
    $gateway_service_mock = $this->createMock(PaymentGatewayService::class); # MOCK THE TEST DOUBLE
    $email_service_mock = $this->createMock(EmailService::class); # MOCK THE TEST DOUBLE

    $gateway_service_mock
    ->method('charge')
    ->willReturn(true); # STUB

    $email_service_mock
    ->expects($this->once())
    ->method('send')
    ->with(['name' => 'Zepp'], 'receipt'); # MOCK

    # Given Invoice Service
    $invoice_service = new InvoiceService($sales_tax_service_mock, $gateway_service_mock, $email_service_mock);

    $customer = ['name' => 'Zepp'];
    $amount = 150;
    # When process is called
    $result = $invoice_service->process($customer, $amount);
    # Then assert invoice is processed successfully
    $this->assertTrue($result);
  }

}