<?php

declare(strict_types = 1);

use App\Model;

class Transaction extends Model
{
    public function create(
        \DateTime $dateTime,
        int $checkNumber,
        string $description,
        float $amount,
    ) 
    {
        $stmt = $this->db->prepare(
            'INSERT INTO tranactions (date, check_number, description, amount)
            VALUES (?, ?, ?, ?)'
        );

        $stmt->execute($dateTime, $checkNumber, $description, $amount);
    }
}