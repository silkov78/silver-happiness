<?php

declare(strict_types=1);

namespace App\Controllers;

use App\View;

class TransactionsController
{
    public function getTransactions(): View
    {
        return View::make('transactions/index');
    }

    public function getForm(): View
    {
        return View::make('transactions/form');
    }
//
//    public function getForm(): View
//    {
//        return View::make
//    }
}