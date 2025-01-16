<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Attributes\Route;
use App\View;
use App\Tools\CsvFilesHandler;
use App\Models\Transaction;

class TransactionsController
{
    #[Route('/transactions')]
    public function getForm(): View
    {
        return View::make('transactions/form');
    }

    #[Route('/transactions/upload')]
    public function getTransactions()
    {
        $transactionsList = (new Transaction())->fetchAll();

        return View::make(
            'transactions/index',
            ['transactionsList' => $transactionsList]
        );
    }

    #[Route('/transactions/upload', 'post')]
    public function uploadTransactions(): View
    {
        $csvHandler = new CsvFilesHandler($_FILES['csv_files']);
        $parsedTransactions = $csvHandler->extractTransactions();

        echo '<pre>';
        print_r($parsedTransactions);
        echo '</pre>';

        (new Transaction())->createMany($parsedTransactions);

        return View::make('transactions/result');
    }
    }
