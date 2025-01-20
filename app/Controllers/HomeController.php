<?php

declare(strict_types = 1);

namespace App\Controllers;

use App\View;
use App\Services\InvoiceService;
use App\Attributes\Get;
use App\Attributes\Put;
use App\Attributes\Post;

class HomeController
{
    public function __construct(private InvoiceService $invoiceService)
    {    
    }

    #[Get(path: '/')]
    public function index(): View
    {   
        $this->invoiceService->process(['nikita'], 25);
        return View::make('index');
    }

    #[Post('/')]
    public function store()
    {   

    }

    #[Put('/')]
    public function update()
    {   

    }

}
