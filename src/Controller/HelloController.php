<?php

namespace App\Controller;
use App\service\StringUtils;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/hello")
 */
class HelloController {


    /**
     * @Route("/{name}" )
     */
    public function world(StringUtils $stringUtils, $name)
    {
       $name= $stringUtils->capitalize($name);

        return new Response("<h2>Hello-$name</h2>") ;
    }
}