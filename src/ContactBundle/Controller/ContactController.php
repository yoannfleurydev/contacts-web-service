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
use ContactBundle\DTO\Error\ConstraintViolationErrorDto;
use ContactBundle\Entity\Contact;
use ContactBundle\Exception\ConstraintViolationException;
use ContactBundle\Exception\ContactUnprocessableEntityHttpException;
use ContactBundle\Exception\PhoneUnprocessableEntityHttpException;
use ContactBundle\HttpFoundation\JsonResponse;
use ContactBundle\Service\ContactService;
use ContactBundle\Service\PhoneService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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
     * Expose the contacts entities
     *
     * @Route("/contacts")
     * @Method({"GET"})
     *
     * @param ContactService $contactService The contact service injection
     *
     * @return Response
     */
    public function readAllAction(ContactService $contactService)
    {
        $contacts = $contactService->getAllContactsByUser($this->getUser());

        return JsonResponse::OK(
            $this->_serializer->serialize($contacts, 'json')
        );
    }

    /**
     * Expose a contact entity
     *
     * @Route("/contacts/{id}")
     * @Method({"GET"})
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
     * Route to add contacts. Send JSON with the correct data to add
     * a \ContactBundle\Entity\Contact.
     *
     * @Route("/contacts")
     * @Method({"POST"})
     *
     * @param Request $request The request send by the client.
     * @param ContactService $contactService
     * @param ContactAssembler $contactAssembler
     *
     * @param ValidatorInterface $validator
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
     * Route to remove a contact.
     *
     * @Route("/contacts/{id}")
     * @Method({"DELETE"})
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
