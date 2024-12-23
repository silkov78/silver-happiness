<?php

declare(strict_types = 1);

namespace App\Controllers;

use App\View;

class UploadController
{   
    public function form(): View
    {
        return View::make('upload/form');
    }

    public function upload(): View
    {
        return View::make('upload/result');
    }
}
