<?php

declare(strict_types=1);

namespace App\Tools;

use App\Exceptions\FileNotFoundException;

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

        $amount = (float) str_replace(['$', ','], '', $amount);

        return [
            'date' => $date,
            'checkNumber' => $checkNumber,
            'description' => $description,
            'amount' => $amount
        ];
    }
}