<?php

declare(strict_types=1);

namespace App\Services;

class AnotherPaymentGatewayService implements PaymentGatewayServiceInterface
{

  public function charge(array $customer, float $amount, float $tax): bool
  {
    # sleep(1);

    echo 'You\'re doing ANOTHER payment service<br />';

    return true;
  }

}