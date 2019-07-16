<?php

namespace App\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/hello")
 */
class HelloController {


    /**
     * @Route("/{name}" )
     */
    public function world($name){


        return new Response("<h2>Hello-$name</h2>") ;
    }
}