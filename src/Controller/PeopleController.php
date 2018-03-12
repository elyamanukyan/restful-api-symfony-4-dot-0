<?php
/**
 * Created by PhpStorm.
 * User: elya
 * Date: 3/9/18
 * Time: 12:49 PM
 */

namespace App\Controller;


use App\Entity\People;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * Class PeopleController
 * @package App\Controller
 * @ApiResource
 */
class PeopleController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function homepage() {
        return new Response('Just Welcome Page');
    }

    /**
     * @Route("/showPeople/{id}")
     */
    public function showPeople($id) {

        $people = $this->getDoctrine()->getRepository(People::class)->find($id);

        if (empty($people)){
            $response=array(
                'code'=>false,
                'message'=>'post not found',
                'error'=>null,
                'result'=>null
            );
            return new JsonResponse($response, Response::HTTP_NOT_FOUND);
        }

        $response=array(
            'code'=>true,
            'message'=>'success',
            'errors'=>null,
            'result'=>json_encode((array) $people)
        );

        return new JsonResponse($response,200);

    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @Route("/addPeople", name="addPeople")
     * @Method({"POST"})
     */

    public function addPeople(Request $request)
    {
        $data=$request->getContent();
        if (!empty($reponse)){
            return new JsonResponse($reponse, Response::HTTP_BAD_REQUEST);
        }
        $entityManager=$this->getDoctrine()->getManager();
        $entityManager->persist($data);
        $entityManager->flush();
        $response=array(
            'code'=>0,
            'message'=>'Post created!',
            'errors'=>null,
            'result'=>null
        );
        return new JsonResponse($response,Response::HTTP_CREATED);
    }

    /**
     *
     * @Route("/listPeople",name="listPeople")
     * @Method({"GET"})
     */

    public function listPeople()
    {
        $people=$this->getDoctrine()->getRepository(People::class)->findAll();
        if (!count($people)){
            $response=array(
                'code'=>false,
                'message'=>'No posts found!',
                'errors'=>null,
                'result'=>null
            );
            return new JsonResponse($response, Response::HTTP_NOT_FOUND);
        }
        foreach ($people as $key=>$value){
            $people[$key] = (array) $value;
        }
        $response=array(
            'code'=>true,
            'message'=>'success',
            'errors'=>null,
            'result'=>json_encode($people)
        );
        return new JsonResponse($response,200);
    }



}