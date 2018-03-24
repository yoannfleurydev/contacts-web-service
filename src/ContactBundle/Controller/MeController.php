<?php

namespace ContactBundle\Controller;

use ContactBundle\Assembler\UserAssembler;
use ContactBundle\HttpFoundation\JsonResponse;
use ContactBundle\Service\UserService;
use JMS\Serializer\SerializerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Swagger\Annotations as SWG;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MeController extends Controller
{
    /**
     * The serializer to transform DTO to JSON.
     *
     * @var SerializerInterface
     */
    private $_serializer;

    /**
     * ContactController constructor.
     * @param SerializerInterface $serializer
     */
    public function __construct(SerializerInterface $serializer)
    {
        $this->_serializer = $serializer;
    }

    /**
     * Route to set the avatar of the user. Send multipart request with
     * the file as field.
     *
     * @Route("/users/me/images")
     * @Method({"POST"})
     * @SWG\Post(
     *     path="/users/me/images",
     *     tags={"users"},
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="user",
     *         in="body",
     *         required=true,
     *         type="object",
     *         @Model(type=ContactBundle\DTO\UserDto::class)
     *     ),
     *     @SWG\Response(
     *         response=204,
     *         description="Updated",
     *         @Model(type=ContactBundle\DTO\UserDto::class)
     *     ),
     *     @SWG\Response(
     *         response=409,
     *         description="User already exists"
     *     )
     * )
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
     * @Route("/users/me")
     * @Method({"GET"})
     * @SWG\Get(
     *     path="/users/me",
     *     tags={"users"},
     *     produces={"application/json"},
     *     @SWG\Response(
     *         response=200,
     *         description="The data for the current user has been found",
     *         @Model(type=ContactBundle\DTO\UserDto::class)
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         description="The current user is not connected"
     *     )
     * )
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
