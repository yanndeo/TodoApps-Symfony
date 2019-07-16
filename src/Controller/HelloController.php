<?php

namespace App\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HelloController {


    /**
     * @Route("/")
     */
    public function world(){

        return new Response("<h2>Hello-word</h2>") ;
    }
}