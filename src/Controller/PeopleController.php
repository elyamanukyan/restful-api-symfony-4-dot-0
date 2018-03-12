<?php

namespace App\Controller;

use App\Entity\People;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

/**
 * Class PeopleController
 * @package App\Controller
 * @ApiResource
 */
class PeopleController extends AbstractController
{
    /*********************************
     *********************************
     * Api Call for single people data
     *********************************
     ********************************/
    /**
     * @Route("/showPeople/{id}")
     */
    public function showPeople($id)
    {
        $people = $this->getDoctrine()->getRepository(People::class)->find($id);

        if (empty($people)) {
            $response = array(
                'code' => false,
                'message' => 'People Not Found',
                'error' => null,
                'result' => null
            );
            return new JsonResponse($response, Response::HTTP_NOT_FOUND);
        }

        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(1);
        // Add Circular reference handler
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers, array(new JsonEncoder()));

        $data = $serializer->serialize($people, 'json');

        $response = array(
            'code' => true,
            'message' => 'success',
            'errors' => null,
            'result' => json_decode($data)
        );

        return new JsonResponse($response, 200);

    }

    /*********************************
     *********************************
     * Api Call for create people data
     *********************************
     ********************************/
    /**
     * @param Request $request
     * @return JsonResponse
     * @Route("/addPeople", name="addPeople")
     * @Method({"POST"})
     */
    public function addPeople(Request $request)
    {
        $data = $request->query->all();

        $serializer = new Serializer(array(new ObjectNormalizer()), array(new JsonEncoder()));
        $people = $serializer->deserialize(json_encode($data), People::class, 'json');

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($people);
        $entityManager->flush();

        $response = array(
            'code' => true,
            'message' => 'People Created!',
            'errors' => null,
            'result' => null
        );

        return new JsonResponse($response, Response::HTTP_CREATED);

    }

    /*********************************
     *********************************
     * Api Call for get all people data
     *********************************
     ********************************/
    /**
     *
     * @Route("/listPeople",name="listPeople")
     * @Method({"GET"})
     */
    public function listPeople()
    {
        $people = $this->getDoctrine()->getRepository(People::class)->findAll();

        if (!count($people)) {
            $response = array(
                'code' => false,
                'message' => 'No People Found!',
                'errors' => null,
                'result' => null
            );
            return new JsonResponse($response, Response::HTTP_NOT_FOUND);
        }

        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(1);
        // Add Circular reference handler
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers, array(new JsonEncoder()));

        $data = $serializer->serialize($people, 'json');

        $response = array(
            'code' => true,
            'message' => 'success',
            'errors' => null,
            'result' => json_decode($data)
        );

        return new JsonResponse($response, 200);
    }

    /*********************************
     *********************************
     * Api Call for update people data
     *********************************
     ********************************/
    /**
     * @param Request $request
     * @param $id
     * @Route("/updatePeople/{id}",name="updatePeople")
     * @Method({"PUT"})
     * @return JsonResponse
     */
    public function updatePeople(Request $request, $id)
    {
        $people = $this->getDoctrine()->getRepository(People::class)->find($id);
        if (empty($people)) {
            $response = array(
                'code' => false,
                'message' => 'People Not Found !',
                'errors' => null,
                'result' => null
            );
            return new JsonResponse($response, Response::HTTP_NOT_FOUND);
        }

        $body = $request->query->all();

        $serializer = new Serializer(array(new ObjectNormalizer()), array(new JsonEncoder()));
        $data = $serializer->deserialize(json_encode($body), People::class, 'json');

        $people->setName($data->getName());
        $people->setSurname($data->getSurname());
        $people->setEmail($data->getEmail());

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($people);
        $entityManager->flush();

        $response = array(
            'code' => 0,
            'message' => 'People Updated!',
            'errors' => null,
            'result' => null
        );
        return new JsonResponse($response, 200);
    }

    /*********************************
     *********************************
     * Api Call for delete people data
     *********************************
     ********************************/
    /**
     * @Route("/deletePeople/{id}",name="deletePeople")
     * @Method({"DELETE"})
     */
    public function deletePeople($id)
    {

        $people = $this->getDoctrine()->getRepository(People::class)->find($id);
        if (empty($people)) {
            $response = array(
                'code' => false,
                'message' => 'People Not Found !',
                'errors' => null,
                'result' => null
            );
            return new JsonResponse($response, Response::HTTP_NOT_FOUND);
        }
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($people);
        $entityManager->flush();
        $response = array(
            'code' => true,
            'message' => 'People Deleted !',
            'errors' => null,
            'result' => null
        );
        return new JsonResponse($response, 200);
    }


}