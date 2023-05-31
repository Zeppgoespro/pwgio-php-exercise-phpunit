<?php

declare(strict_types=1);

namespace App\Models;

use App\Model;

class SignUp extends Model
{

  public function __construct(protected User $user_model, protected Invoice $invoice_model)
  {
    parent::__construct();
  }

  public function register(array $user_info, array $invoice_info): int
  {
    try {

      $this->db->beginTransaction(); # TRANSACTION


      $user_id = $this->user_model->create($user_info['email'], $user_info['name']);
      $invoice_id = $this->invoice_model->create($invoice_info['amount'], $user_id);


      $this->db->commit();

    } catch (\Throwable $e) {
      if ($this->db->inTransaction()):
        $this->db->rollBack();
      endif;

      throw $e;
    }

    return $invoice_id;

  }

}