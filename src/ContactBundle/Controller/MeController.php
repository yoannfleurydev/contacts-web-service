<?php

namespace ContactBundle\Controller;

use ContactBundle\Assembler\UserAssembler;
use ContactBundle\HttpFoundation\JsonResponse;
use ContactBundle\Service\UserService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MeController extends Controller
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
     * Route to set the avatar of the user. Send multipart request with
     * the file as field.
     *
     * @Route("/me/images")
     * @Method({"POST"})
     *
     * @param Request $request The request sent by the client
     * @param UserService $userService The user service injection
     * @param UserAssembler $userAssembler The user assembler injection
     *
     * @return Response The response of the updated images.
     */
    public function setMyImagesAction(
        Request $request,
        UserService $userService,
        UserAssembler $userAssembler
    ) {
        $avatar = $request->files->get('avatar');
        if (isset($avatar)) {
            $userService->setAvatar($avatar, $this->getUser());
        }

        $background = $request->files->get('background');
        if (isset($background)) {
           $userService->setBackground($background, $this->getUser());
        }

        return JsonResponse::OK(
            $this->_serializer->serialize($userAssembler->entityToDto(
                $this->getUser()
            ), 'json')
        );
    }

    /**
     * Route to set the avatar of the user. Send multipart request with
     * the file as field.
     *
     * @Route("/me")
     * @Method({"GET"})
     *
     * @param UserAssembler $userAssembler The user assembler injection
     *
     * @return Response The response that contains data about the current user.
     */
    public function meAction(UserAssembler $userAssembler) {
        return JsonResponse::OK(
            $this->_serializer->serialize($userAssembler->entityToDto(
                $this->getUser()
            ), 'json')
        );
    }
}
