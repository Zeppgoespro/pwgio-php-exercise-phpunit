<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Services\InvoiceService;

class InvoiceController
{

  public function __construct(private InvoiceService $invoiceService)
  {
    # Constructor DEPENDENCY INJECTION
  }

  public function store()
  {
    $name = $_GET['name'];
    $amount = $_GET['amount'];

    $this->invoiceService->process(
      ['name' => $name],
      $amount
    );
  }

}