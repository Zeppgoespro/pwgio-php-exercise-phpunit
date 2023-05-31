<?php

declare(strict_types=1);

namespace App\Models;

use App\Model;

class Invoice extends Model
{

  public function create(float $amount, int $user_id): int
  {
    $stmt = $this->db()->prepare("INSERT INTO invoices (amount, user_id) VALUES (?,?)");

    $stmt->execute([$amount, $user_id]);

    return (int) $this->db->lastInsertId();
  }

  public function find(int $invoice_id): array
  {
    $stmt = $this->db->prepare(
      'SELECT invoices.id, amount, users.full_name
       FROM invoices
       LEFT JOIN users ON users.id = user_id
       WHERE invoices.id = ?
      '
    );

    $stmt->execute([$invoice_id]);

    $invoice = $stmt->fetch();

    return $invoice ? $invoice : []; # need to know better
  }

}