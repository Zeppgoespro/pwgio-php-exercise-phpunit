<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Services\SalesTaxService;
use App\Services\PaymentGatewayService;
use App\Services\EmailService;

class TestingInvoiceService
{
  public function __construct(
    public SalesTaxService $sales_tax_service,
    public PaymentGatewayService $gateway_service,
    public EmailService $email_service
  )
  {
    # Constructor DEPENDENCY INJECTION
  }

  public function process(array $customer, float $amount): bool
  {
    # 1. Calculate sales tax.
    $tax = $this->sales_tax_service->calculate($amount, $customer);

    # 2. Process invoice.
    if (! $this->gateway_service->charge($customer, $amount, $tax)):
      return false;
    endif;

    # 3. Send receipt.
    $this->email_service->send($customer, 'receipt');

    echo 'Invoice has been processed<br />';

    return true;
  }

}