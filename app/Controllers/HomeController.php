<?php

declare(strict_types = 1);

namespace App\Controllers;

use App\View;
use App\Container;
use App\Services\InvoiceService;

class HomeController
{
    public function __construct(
        private InvoiceService $invoiceService
    ) {    
    }

    public function index(): View
    {   
        $this->invoiceService->process(['nikita'], 25);
        return View::make('index');
    }
}
