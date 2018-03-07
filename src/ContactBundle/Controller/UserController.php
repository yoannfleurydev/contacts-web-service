<?php

namespace ContactBundle\Controller;

use ContactBundle\Assembler\UserAssembler;
use ContactBundle\DTO\Error\ConstraintViolationErrorDto;
use ContactBundle\Exception\ConstraintViolationException;
use ContactBundle\HttpFoundation\JsonResponse;
use ContactBundle\Service\UserService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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
     * @Route("/users")
     * @Method({"POST"})
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
    public function addAction(Request $request, UserService $userService, UserAssembler $userAssembler, ValidatorInterface $validator)
    {
        $json = $request->getContent();
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
