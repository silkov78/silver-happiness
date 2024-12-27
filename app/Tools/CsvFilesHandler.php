<?php

declare(strict_types=1);

namespace App\Tools;

use App\Exceptions\FileNotFoundException;
use DateTime;

class CsvFilesHandler
{
    public function __construct(array $attachedFilesInfo)
    {
        $this->attachedFilesInfo = $this->transformFilesArray($attachedFilesInfo);
    }

    public function getTransactions(): array
    {
        $transactions = [];

        foreach ($this->attachedFiles["tmp_name"] as $file) {
            $file = fopen($file, 'r');

            fgetcsv($file);
            while (($transaction = fgetcsv($file)) !== false) {
                $transactions[] = $this->parseTransaction($transaction);
            }
        }

        return $transactions;
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
