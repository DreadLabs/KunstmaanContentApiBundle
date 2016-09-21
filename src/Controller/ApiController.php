<?php

namespace DreadLabs\KunstmaanContentApiBundle\Controller;

use DreadLabs\KunstmaanContentApiBundle\Api\Exception;
use DreadLabs\KunstmaanContentApiBundle\Api\Factory;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Serializer;

class ApiController extends Controller
{
    /**
     * @var Serializer
     */
    private $serializer;

    /**
     * @var \DreadLabs\KunstmaanContentApiBundle\Api\Factory
     */
    private $factory;

    public function __construct(Serializer $serializer, Factory $factory)
    {
        $this->serializer = $serializer;
        $this->factory = $factory;
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse|void
     */
    public function getAction(Request $request)
    {
        try {
            $api = $this->factory->createFromRequestParameterBag($request->attributes);
            $json = $this->serializer->normalize($api, 'json', ['groups' => ['public']]);

            return new JsonResponse($json);
        } catch (Exception $exc) {
            return;
        }
    }
}
