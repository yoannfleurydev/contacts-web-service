<?php
/**
 * File for the contact controller.
 *
 * PHP version 7.1
 *
 * @category Contact
 * @package  ContactBundle\Controller
 * @author   Yoann Fleury <yoann.fleury@yahoo.com>
 * @license  MIT License
 * @link     /contacts
 */

namespace ContactBundle\Controller;

use ContactBundle\Assembler\ContactAssembler;
use ContactBundle\Entity\Contact;
use ContactBundle\Exception\ContactUnprocessableEntityHttpException;
use ContactBundle\Exception\PhoneUnprocessableEntityHttpException;
use ContactBundle\HttpFoundation\JsonResponse;
use ContactBundle\Service\ContactService;
use ContactBundle\Service\PhoneService;
use Nelmio\ApiDocBundle\Annotation\Model;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Swagger\Annotations as SWG;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Contact controller.
 *
 * PHP version 7.1
 *
 * @category Contact
 * @package  ContactBundle\Controller
 * @author   Yoann Fleury <yoann.fleury@yahoo.com>
 * @license  MIT License
 * @link     /contacts
 */
class ContactController extends Controller
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
     * Expose the contacts entities for the user.
     *
     * @Route("/contacts")
     * @Method({"GET"})
     * @SWG\Get(
     *     path="/contacts",
     *     tags={"contacts"},
     *     produces={"application/json"},
     *     @SWG\Response(
     *         response=200,
     *         description="Listing of the contacts",
     *         @SWG\Schema(
     *             type="array",
     *             @Model(type=ContactBundle\DTO\ContactDto::class)
     *         )
     *     )
     * )
     *
     * @param ContactService $contactService The contact service injection
     *
     * @return Response
     * @throws \Doctrine\ORM\ORMException
     */
    public function readAllAction(ContactService $contactService)
    {
        $contacts = $contactService->getAllContactsByUser($this->getUser());

        return JsonResponse::OK(
            $this->_serializer->serialize($contacts, 'json')
        );
    }

    /**
     * Expose a contact entity that the user owns.
     *
     * @Route("/contacts/{id}")
     * @Method({"GET"})
     * @SWG\Get(
     *     path="/contacts/{id}",
     *     tags={"contacts"},
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         description="Identifier of contact to get",
     *         required=true,
     *         type="string",
     *         format="uuid"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="The contact has been found",
     *         @Model(type=ContactBundle\DTO\ContactDto::class)
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="The contact found"
     *     )
     * )
     *
     * @param Contact $contact The contact that match the id in the route
     * @param ContactAssembler $contactAssembler The contact assembler injection
     *
     * @return Response
     */
    public function readAction(Contact $contact, ContactAssembler $contactAssembler)
    {
        return JsonResponse::OK(
            $this->_serializer->serialize(
                $contactAssembler->entityToDto($contact),
                'json'
            )
        );
    }

    /**
     * Add contacts for the user.
     *
     * @Route("/contacts")
     * @Method({"POST"})
     * @SWG\Post(
     *     path="/contacts",
     *     tags={"contacts"},
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="contact",
     *         in="body",
     *         required=true,
     *         type="object",
     *         @Model(type=ContactBundle\DTO\ContactDto::class)
     *     ),
     *     @SWG\Response(
     *         response=201,
     *         description="Created",
     *         @Model(type=ContactBundle\DTO\ContactDto::class)
     *     )
     * )
     *
     * @param Request $request The request send by the client.
     * @param ContactService $contactService
     * @param ContactAssembler $contactAssembler
     *
     * @return Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function createAction(
        Request $request,
        ContactService $contactService,
        ContactAssembler $contactAssembler
    ) {
        $json = $request->getContent();

        if (empty($json)) {
            throw new ContactUnprocessableEntityHttpException();
        }

        $contactDto = $this->_serializer->deserialize(
            $json, 'ContactBundle\DTO\ContactDto', 'json'
        );

        $contactDto = $contactAssembler->entityToDto(
            $contactService->createContact($contactDto, $this->getUser())
        );

        $json = $this->_serializer->serialize($contactDto, 'json');
        return JsonResponse::CREATED($json);
    }

    /**
     * Remove a contact for the user.
     *
     * @Route("/contacts/{id}")
     * @Method({"DELETE"})
     * @SWG\Delete(
     *     path="/contacts/{id}",
     *     produces={"application/json"},
     *     tags={"contacts"},
     *     @SWG\Parameter(
     *         description="Contact id to delete",
     *         in="path",
     *         name="id",
     *         required=true,
     *         type="string",
     *         format="uuid"
     *     ),
     *     @SWG\Response(
     *         response=204,
     *         description="Contact deleted"
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Contact not found"
     *     )
     * )
     *
     * @param Contact $contact The contact that match the id in the route
     * @param ContactService $contactService The contact service injection
     *
     * @return Response The response with a 204 NO CONTENT if everything is
     *                      good or an error instead.
     */
    public function deleteAction(Contact $contact, ContactService $contactService)
    {
        $contactService->deleteContact($contact);
        return JsonResponse::NO_CONTENT();
    }

    /**
     * Route to add a phone number to a contact.
     *
     * @Route("/contacts/{id}/phones")
     * @Method({"POST"})
     * @SWG\Post(
     *     path="/contacts/{id}/phones",
     *     tags={"contacts"},
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         description="Identifier of the contact to add a phone",
     *         in="path",
     *         name="id",
     *         required=true,
     *         type="string",
     *         format="uuid"
     *     ),
     *     @SWG\Parameter(
     *         name="phone",
     *         in="body",
     *         required=true,
     *         type="object",
     *         @Model(type=ContactBundle\DTO\PhoneDto::class)
     *     ),
     *     @SWG\Response(
     *         response=201,
     *         description="Created",
     *         @Model(type=ContactBundle\DTO\PhoneDto::class)
     *     )
     * )
     *
     * @param Request $request The request to get the phone to add to a contact.
     * @param string $id The identifier of the contact.
     * @param ContactService $contactService The contact service injection
     * @param PhoneService $phoneService The phone service injection
     *
     * @return Response The response with a 201 CREATED if everything is
     *                      good or an error instead.
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function addPhoneAction(Request $request, $id, ContactService $contactService, PhoneService $phoneService)
    {
        $json = $request->getContent();

        if (empty($json)) {
            throw new PhoneUnprocessableEntityHttpException();
        }

        $phoneDto = $this->_serializer->deserialize(
            $json, 'ContactBundle\DTO\PhoneDto', 'json'
        );

        $phoneService->createPhone($phoneDto, $id);
        $contactDto = $contactService->get($id);

        return JsonResponse::CREATED(
            $this->_serializer->serialize($contactDto, 'json')
        );
    }
}
