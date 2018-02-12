<?php

namespace ContactBundle\Controller;

use ContactBundle\Assembler\UserAssembler;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;
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
     * The contact service to do the logic.
     *
     * @var \ContactBundle\Service\UserService
     */
    private $_userService;

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
        $this->_userService = $this->get('contact.service.user');
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
     * @return Response
     */
    public function addAction(Request $request)
    {
        $json = $request->getContent();
        $userDto = $this->_serializer->deserialize(
            $json,
            'ContactBundle\DTO\UserDto',
            'json'
        );

        $this->_userService->createUser($userDto);

        $json = $this->_serializer->serialize($userDto, 'json');
        return new Response(
            $json,
            Response::HTTP_CREATED,
            ["Content-Type" => "application/json"]
        );
    }

    /**
     * Route to set the avatar of the user. Send multipart request with
     * the file as field.
     *
     * @Route("/me/images")
     * @Method({"POST"})
     *
     * @param Request $request
     * @return Response The response
     */
    public function setMyImagesAction(Request $request)
    {
        $avatar = $request->files->get('avatar');
        if (isset($avatar)) {
            $this->_userService->setAvatar($avatar, $this->getUser());
        }

        $background = $request->files->get('background');
        if (isset($background)) {
           $this->_userService->setBackground($background, $this->getUser());
        }

        return new Response(
            $this->_serializer->serialize(UserAssembler::entityToDto(
                $this->getUser()
            ), 'json'),
            Response::HTTP_OK,
            ["Content-Type" => "application/json"]
        );
    }
}
