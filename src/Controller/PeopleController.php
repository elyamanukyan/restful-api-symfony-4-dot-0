<?php
/**
 * Created by PhpStorm.
 * User: elya
 * Date: 3/9/18
 * Time: 12:49 PM
 */

namespace App\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class PeopleController
{
    /**
     * @Route("/")
     */
    public function homepage() {
        return new Response('Teeeext');
    }

    /**
     * @Route("/human/{name}")
     */
    public function show($name) {
        return new Response(sprintf(
            "humaaaan text: %s",
            $name
        ));
    }

}git 