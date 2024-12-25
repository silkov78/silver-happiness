<?php

declare(strict_types = 1);

namespace App\Models;

use App\Model;

class Transaction extends Model
{
    public function create(
        string $dateTime,
        int $checkNumber,
        string $description,
        float $amount,
    ): void
    {
        $stmt = $this->db->prepare(
            'INSERT INTO transactions (date, check_number, description, amount)
            VALUES (?, ?, ?, ?)'
        );

        $stmt->execute([$dateTime, $checkNumber, $description, $amount]);
    }
}