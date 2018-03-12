<?php

namespace App\Controller;

use App\Entity\PhoneNumbers;
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
 * Class PhoneNumbersController
 * @package App\Controller
 * @ApiResource
 */
class PhoneNumbersController extends AbstractController
{
    /**************************************
     **************************************
     * Api Call for single PhoneNumber data
     **************************************
     *************************************/
    /**
     * @Route("/showPhoneNumber/{id}")
     */
    public function showPhoneNumber($id)
    {
        $phoneNumber = $this->getDoctrine()->getRepository(PhoneNumbers::class)->find($id);

        if (empty($phoneNumber)) {
            $response = array(
                'code' => false,
                'message' => 'Number Not Found',
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
        $data = $serializer->serialize($phoneNumber, 'json');

        $response = array(
            'code' => true,
            'message' => 'success',
            'errors' => null,
            'result' => json_decode($data)
        );

        return new JsonResponse($response, 200);
    }

    /**************************************
     **************************************
     * Api Call for Create PhoneNumber data
     **************************************
     *************************************/
    /**
     * @param Request $request
     * @return JsonResponse
     * @Route("/addPhoneNumber", name="addPhoneNumber")
     * @Method({"POST"})
     */
    public function addPhoneNumber(Request $request)
    {
        $data = $request->query->all();

        $serializer = new Serializer(array(new ObjectNormalizer()), array(new JsonEncoder()));
        $phoneNumber = $serializer->deserialize(json_encode($data), PhoneNumbers::class, 'json',array('groups' => array('default')));

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($phoneNumber);
        $entityManager->flush();

        $response = array(
            'code' => true,
            'message' => 'Number Created!',
            'errors' => null,
            'result' => null
        );
        return new JsonResponse($response, Response::HTTP_CREATED);
    }

    /*****************************************
     *****************************************
     * Api Call for show all PhoneNumber data
     *****************************************
     ****************************************/
    /**
     *
     * @Route("/listPhoneNumbers",name="listPhoneNumbers")
     * @Method({"GET"})
     */
    public function listPhoneNumbers()
    {
        $phoneNumbers = $this->getDoctrine()->getRepository(PhoneNumbers::class)->findAll();

        if (!count($phoneNumbers)) {
            $response = array(
                'code' => false,
                'message' => 'No Numbers Found!',
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
        $data = $serializer->serialize($phoneNumbers, 'json');

        $response = array(
            'code' => true,
            'message' => 'success',
            'errors' => null,
            'result' => json_decode($data)
        );

        return new JsonResponse($response, 200);
    }

    /**************************************
     **************************************
     * Api Call for Update PhoneNumber data
     **************************************
     *************************************/
    /**
     * @param Request $request
     * @param $id
     * @Route("/updatePhoneNumber/{id}",name="updatePhoneNumber")
     * @Method({"PUT"})
     * @return JsonResponse
     */
    public function updatePhoneNumber(Request $request, $id)
    {
        $phoneNumber = $this->getDoctrine()->getRepository(PhoneNumbers::class)->find($id);
        if (empty($phoneNumber)) {
            $response = array(
                'code' => false,
                'message' => 'Number Not Found !',
                'errors' => null,
                'result' => null
            );
            return new JsonResponse($response, Response::HTTP_NOT_FOUND);
        }

        $body = $request->query->all();

        $serializer = new Serializer(array(new ObjectNormalizer()), array(new JsonEncoder()));
        $data = $serializer->deserialize(json_encode($body), PhoneNumbers::class, 'json');

        $phoneNumber->setNumber($data->getNumber());
        $phoneNumber->setPeopleId($data->getPeopleId());

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($phoneNumber);
        $entityManager->flush();

        $response = array(
            'code' => 0,
            'message' => 'Number Updated!',
            'errors' => null,
            'result' => null
        );
        return new JsonResponse($response, 200);
    }

    /**************************************
     **************************************
     * Api Call for delete PhoneNumber data
     **************************************
     *************************************/
    /**
     * @Route("/deletePhoneNumber/{id}",name="deletePhoneNumber")
     * @Method({"DELETE"})
     */
    public function deletePhoneNumber($id)
    {
        $phoneNumber = $this->getDoctrine()->getRepository(PhoneNumbers::class)->find($id);
        if (empty($phoneNumber)) {
            $response = array(
                'code' => false,
                'message' => 'Phone Number Not Found !',
                'errors' => null,
                'result' => null
            );
            return new JsonResponse($response, Response::HTTP_NOT_FOUND);
        }
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($phoneNumber);
        $entityManager->flush();
        $response = array(
            'code' => true,
            'message' => 'Phone Number Deleted !',
            'errors' => null,
            'result' => null
        );
        return new JsonResponse($response, 200);
    }


}