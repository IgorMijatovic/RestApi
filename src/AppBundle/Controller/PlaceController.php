<?php

namespace AppBundle\Controller;

use AppBundle\AppBundle;
use AppBundle\Entity\Place;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PlaceController extends Controller
{
    /**
     * @Route("/places", name="places_list")
     * @Method({"GET"})
     */
    public function getPlacesAction(Request $request)
    {
        /**
         * @var $places Place[]
         */
        $places = $this->getDoctrine()->getManager()
            ->getRepository('AppBundle:Place')
            ->findAll();

        $formatted = [];

        foreach ($places as $place) {
            $formatted[] = [
                'id' => $place->getId(),
                'name' => $place->getName(),
                'address' => $place->getAddress()
            ];
        }

        return new JsonResponse($formatted);
    }

        /**
         * @Route("/places/{place_id}",requirements={"place_id" = "\d+"}, name="places_one")
         * @Method({"GET"})
         */
        public function getPlaceAction(Request $request)
        {
            $place = $this->getDoctrine()->getManager()
                ->getRepository('AppBundle:Place')
                ->find($request->get('place_id'));
            /* @var $place Place */

            if (empty($place)) {
                return new JsonResponse(['message' => 'Place not found'], Response::HTTP_NOT_FOUND);
            }

            $formatted = [
                'id' => $place->getId(),
                'name' => $place->getName(),
                'address' => $place->getAddress(),
            ];

            return new JsonResponse($formatted);
        }
}
