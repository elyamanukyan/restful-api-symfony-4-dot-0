<?php
/**
 * Created by PhpStorm.
 * User: elya
 * Date: 3/9/18
 * Time: 12:49 PM
 */

namespace App\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class PeopleController extends AbstractController
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
//        return new Response(sprintf(
//            "humaaaan text: %s",
//            $name
//        ));
        $phone_numbers = [
            '451551',
            '3212213',
            '25256458',
        ];

        return $this->render('people/show.html.twig',[
            'name' => ucwords(str_replace('-', ' ', $name)),
            'phone_numbers' => $phone_numbers,
        ]);
    }




}