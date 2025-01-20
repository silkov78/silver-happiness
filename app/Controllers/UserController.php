<?php

declare(strict_types = 1);

namespace App\Controllers;

use App\Attributes\Get;
use App\Attributes\Post;
use App\View;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Email;

class UserController
{
    #[Get('/users/create')]
    public function create(): View
    {
        return View::make('users/register');
    }

    #[Post('/users')]
    public function register()
    {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $firstName = explode(' ', $name);

        var_dump($name, $email);

        $text = <<<Body
Hello $firstName,

Thank you for signing up!

Body;
 
        $email = (new Email())
                 ->from('utiputi@example.com')
                 ->to($email)
                 ->subject('Welcome!')
                 ->text($text);

        $dsn = 'smtp://mailhog:1025';

        $transport = Transport::fromDsn($dsn);

        $mailer = new Mailer($transport);

        $mailer->send($email);
        
    }
} 
 