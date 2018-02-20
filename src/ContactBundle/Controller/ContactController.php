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

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use ContactBundle\Assembler\ContactAssembler;
use ContactBundle\Entity\Contact;
use ContactBundle\Exception\ContactUnprocessableEntityHttpException;
use ContactBundle\Exception\PhoneUnprocessableEntityHttpException;
use ContactBundle\Service\ContactService;
use ContactBundle\Service\PhoneService;

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
     * @return Response
     */
    public function readAllAction(ContactService $contactService)
    {
        $contacts = $contactService->getAllContactsByUser($this->getUser());

        return new Response(
            $this->_serializer->serialize($contacts, 'json'),
            Response::HTTP_OK,
            ["Content-Type" => "application/json"]
        );
    }

    /**
     * Expose a contact entity
     *
     * @param string $id The identifier for the contact to get
     *
     * @Route("/contacts/{id}")
     * @Method({"GET"})
     *
     * @return Response
     */
    public function readAction(Contact $contact, ContactAssembler $contactAssembler)
    {
        return new Response(
            $this->_serializer->serialize(
                $contactAssembler->entityToDto($contact),
                'json'
            ),
            Response::HTTP_OK,
            ['Content-Type' => 'application/json']
        );
    }

    /**
     * Route to add contacts. Send JSON with the correct data to add
     * a \ContactBundle\Entity\Contact.
     *
     * @param Request $request The request send by the client.
     *
     * @Route("/contacts")
     * @Method({"POST"})
     *
     * @return Response
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
        return new Response(
            $json,
            Response::HTTP_CREATED,
            ["Content-Type" => "application/json"]
        );
    }

    /**
     * Route to remove a contact.
     *
     * @param integer $id The identifier of the contact to remove.
     *
     * @Route("/contacts/{id}")
     *
     * @return Response The response with a 204 NO CONTENT if everything is good
     *                  or an error instead.
     */
    public function deleteAction(Contact $contact, ContactService $contactService)
    {
        $contactService->deleteContact($contact);

        return new Response(
            '',
            Response::HTTP_NO_CONTENT,
            ['Content-Type' => 'application/json']
        );
    }

    /**
     * Route to add a phone number to a contact.
     *
     * @param Request $request The request to get the phone to add to a contact.
     * @param string  $id      The identifier of the contact.
     *
     * @Route("/contacts/{id}/phones")
     *
     * @return Response The response with a 201 CREATED if everything is good or
     *                  an error instead.
     */
    public function addPhoneAction(Request $request, $id, ContactService $contactService, PhoneService $phoneService)
    {
        $json = $request->getContent();

        if (empty($json)) {
            throw new PhoneUnprocessableEntityHttpException();
        }

        $phoneDto = $this->_serializer->deserialize(
            $json,
            'ContactBundle\DTO\PhoneDto',
            'json'
        );

        $phoneService->createPhone($phoneDto, $id);
        $contactDto = $contactService->get($id);

        return new Response(
            $this->_serializer->serialize($contactDto, 'json'),
            Response::HTTP_CREATED,
            ["Content-Type" => "application/json"]
        );
    }
}
