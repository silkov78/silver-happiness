<?php

declare(strict_types = 1);

namespace App\Controllers;

use App\View;
use App\Container;
use App\Services\InvoiceService;

class HomeController
{
    public function index(): View
    {   
        (new Container())->get(InvoiceService::class)->process(['nikita'], 25);
        return View::make('index');
    }
}
