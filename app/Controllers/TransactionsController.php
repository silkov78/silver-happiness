<?php

declare(strict_types=1);

namespace App\Controllers;

use App\View;
use App\Tools\UploadedFileHandler;
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
       $attachedFile = $_FILES['transactions'];

       if ($attachedFile['type'] !== 'text/csv') {
           throw new InvalidFileException('CSV-file is required.');
       }

       $parsedTransactions = (new UploadedFileHandler($attachedFile['tmp_name']))->getTransactions();

       (new Transaction())->createMany($parsedTransactions);

       return View::make('transactions/result');
   }
}
