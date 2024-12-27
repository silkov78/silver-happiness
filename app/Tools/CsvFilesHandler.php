<?php

declare(strict_types=1);

namespace App\Tools;

use App\Exceptions\FileNotFoundException;
use App\Exceptions\InvalidFileException;
use DateTime;

class CsvFilesHandler
{
    public function __construct(array $attachedFilesInfo)
    {
        $this->attachedFilesInfo = $this->transformFilesArray($attachedFilesInfo);
    }

    public function extractTransactions(): array
    {
        $allTransactions = [];

        foreach ($this->attachedFilesInfo as $fileInfoArray) {
            try {
                $transactionsFromFile = $this->getTransactionsFromFile($fileInfoArray);
                $allTransactions = array_merge($allTransactions, $transactionsFromFile);
            } catch (FileNotFoundException | InvalidFileException $e) {
                echo $e->getMessage();
                continue;
            }
        }

        return $allTransactions;
    }

    private function getTransactionsFromFile(array $fileInfo): array
    {
        $transactions = [];

        $this->validateFile($fileInfo);

        $file = fopen($fileInfo['tmp_name'], 'r');

        fgetcsv($file);
        while (($transaction = fgetcsv($file)) !== false) {
            $transactions[] = $this->parseTransaction($transaction);
        }

        return $transactions;
    }

    private function validateFile(array $fileInfo): void
    {
        if (! file_exists($fileInfo['tmp_name'])) {
            throw new FileNotFoundException(
                "File '{$fileInfo['name']}' is not found!" . '</br>'
            );
        }

        if ($fileInfo['type'] !== 'text/csv') {
            throw new InvalidFileException(
                "File '{$fileInfo['name']}' should be CSV!" . '</br>'
            );
        }

    }

    private function transformFilesArray(array $arr): array
    {
        $out = array();
        foreach ($arr as $key => $subarr) {
            foreach ($subarr as $subkey => $subvalue) {
                $out[$subkey][$key] = $subvalue;
            }
        }
        return $out;
    }

    private function parseTransaction(array $transactionRow): array {

        [$date, $checkNumber, $description, $amount] = $transactionRow;

        $date = DateTime::createFromFormat('d/m/Y', $date);
        $date = $date->format('Y-m-d');

        $checkNumber = (int) $checkNumber;
        $amount = (float) str_replace(['$', ','], '', $amount);

        return [
            'date' => $date,
            'checkNumber' => $checkNumber,
            'description' => $description,
            'amount' => $amount
        ];
    }

}
