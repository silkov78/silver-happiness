<?php

declare(strict_types = 1);

namespace App\Controllers;

use App\Exceptions\InvalidFileException;
use App\Tools\FileUploadHandler;
use App\View;
use App\Models\Transaction;

class UploadController
{   
    public function index(): View
    {
        return View::make('upload/index');
    }

    public function upload()
    {
        $attachedFile = $_FILES['transactions'];

        if ($attachedFile['type'] !== 'text/csv') {
            throw new InvalidFileException('CSV-file is required.');
        }

        $parsedTransactions = (new FileUploadHandler($attachedFile['tmp_name']))->getTransactions();

        foreach ($parsedTransactions as $transaction) {
            (new Transaction)->create(
                $transaction['date'],
                $transaction['checkNumber'],
                $transaction['description'],
                $transaction['amount'],
            );
        }
    }
}
