<?php

namespace ContactBundle\Controller;

use ContactBundle\Assembler\UserAssembler;
use ContactBundle\DTO\Error\ConstraintViolationErrorDto;
use ContactBundle\DTO\UserDto;
use ContactBundle\Exception\ConstraintViolationException;
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
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserController extends Controller
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
     * Route to add user. Send JSON with the correct data to add
     * a \ContactBundle\Entity\User.
     *
     * @Route("/register")
     * @Method({"POST"})
     * @SWG\Post(
     *     path="/register",
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
     *         response=201,
     *         description="Created",
     *         @Model(type=ContactBundle\DTO\UserDto::class)
     *     ),
     *     @SWG\Response(
     *         response=409,
     *         description="User already exists"
     *     )
     * )
     *
     * @param Request $request The request send by the client.
     * @param UserService $userService The user service dependency injection
     * @param UserAssembler $userAssembler The user assembler dependency injection
     *
     * @param ValidatorInterface $validator
     * @return Response JSON response containing the newly created user.
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function registerAction(Request $request, UserService $userService, UserAssembler $userAssembler, ValidatorInterface $validator)
    {
        $json = $request->getContent();

        /** @var UserDto $userDto */
        $userDto = $this->_serializer->deserialize(
            $json,
            'ContactBundle\DTO\UserDto',
            'json'
        );

        $constraintViolationList = $validator->validate($userDto);
        if ($constraintViolationList->count() > 0) {
            $constraintViolationDtoList = ConstraintViolationErrorDto::fromConstraintViolationList($constraintViolationList);
            throw ConstraintViolationException::fromConstraintViolationErrorList($constraintViolationDtoList, $this->_serializer);
        }

        $userService->createUser($userAssembler->dtoToEntity($userDto));

        $json = $this->_serializer->serialize($userDto, 'json');

        return JsonResponse::CREATED($json);
    }
}
