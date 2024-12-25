<?php

declare(strict_types=1);

namespace App\Tools;

use App\Exceptions\FileNotFoundException;
use DateTime;

class FileUploadHandler
{
    public function __construct(private string $csvFilePath)
    {
        if (! file_exists($this->csvFilePath)) {
            throw new FileNotFoundException('Uploaded file' . $this->csvFilePath . ' not found');
        }
    }

    public function getTransactions(): array
    {
        $file = fopen($this->csvFilePath, 'r');

        $transactions = [];

        fgetcsv($file);

        while (($transaction = fgetcsv($file)) !== false) {

            $transactions[] = $this->parseTransaction($transaction);

        }

        return $transactions;

    }

    private function parseTransaction(array $transactionRow): array {

        [$date, $checkNumber, $description, $amount] = $transactionRow;

        $date = DateTime::createFromFormat('d/m/Y', $date);
        $mysqlDateTime = $date->format('Y-m-d');

        $checkNumber = (int) $checkNumber;
        $amount = (float) str_replace(['$', ','], '', $amount);

        return [
            'date' => $mysqlDateTime,
            'checkNumber' => $checkNumber,
            'description' => $description,
            'amount' => $amount
        ];
    }
}