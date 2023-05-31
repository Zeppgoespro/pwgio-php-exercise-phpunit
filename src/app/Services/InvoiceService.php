<?php

declare(strict_types=1);

namespace App\Services;

class InvoiceService
{
  public function __construct(
    protected SalesTaxService $sales_tax_service,
    protected PaymentGatewayServiceInterface $gateway_service,
    protected EmailService $email_service
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