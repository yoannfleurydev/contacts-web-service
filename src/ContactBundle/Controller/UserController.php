<?php

namespace ContactBundle\Controller;

use ContactBundle\Assembler\UserAssembler;
use ContactBundle\HttpFoundation\JsonResponse;
use ContactBundle\Service\UserService;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class UserController extends Controller
{
    /**
     * The serializer to transform DTO to JSON.
     *
     * @var \JMS\Serializer\Serializer
     */
    private $_serializer;

    /**
     * Override of the setContainer method from the Controller class.
     *
     * @param ContainerInterface $container The already existing container will
     *                                      be injected in the parameter.
     *
     * @return void
     */
    public function setContainer(ContainerInterface $container = null)
    {
        parent::setContainer($container);
        $this->_serializer = $this->get('jms_serializer');
    }

    /**
     * Route to add user. Send JSON with the correct data to add
     * a \ContactBundle\Entity\User.
     *
     * @param Request $request The request send by the client.
     *
     * @Route("/users")
     * @Method({"POST"})
     *
     * @return JsonResponse
     */
    public function addAction(Request $request, UserService $userService, UserAssembler $userAssembler)
    {
        $json = $request->getContent();
        $userDto = $this->_serializer->deserialize(
            $json,
            'ContactBundle\DTO\UserDto',
            'json'
        );

        $userService->createUser($userAssembler->dtoToEntity($userDto));

        $json = $this->_serializer->serialize($userDto, 'json');

        return JsonResponse::CREATED($json);
    }
}
