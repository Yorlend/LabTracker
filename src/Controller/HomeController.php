<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController
{
    #[Route('/', name: 'home')]
    public function index(): Response
    {
        return new Response("<h1 style='text-align: center'><a href=\"https://github.com/Yorlend/LabTracker/wiki\">ТЗ Проекта</a></h1>");
    }
}