<?php

declare(strict_types=1);

namespace App\Controllers;

use App\View;
use App\Exceptions\InvalidFileException;
use App\Tools\CsvFilesHandler;
use App\Models\Transaction;

class TransactionsController
{
    public function getForm(): View
    {
        return View::make('transactions/form');
    }

    public function getTransactions()
    {
        $transactionsList = (new Transaction())->fetchAll();

        return View::make(
            'transactions/index',
            ['transactionsList' => $transactionsList]
        );
    }

   public function uploadTransactions(): View
   {
       $csvHandler = new CsvFilesHandler($_FILES['csv_files']);
       $parsedTransactions = $csvHandler->getTransactions();

       (new Transaction())->createMany($parsedTransactions);

       return View::make('transactions/result');
   }
}
