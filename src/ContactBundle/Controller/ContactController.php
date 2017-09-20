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
    private $_serializer;

    private $_contactService;

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
        $this->_contactService = $this->get('contact.service.contact');
    }

    /**
     * Expose the contacts entities
     *
     * @Route("/contacts")
     * @Method({"GET"})
     *
     * @return Response
     */
    public function getAllAction()
    {
        $contacts = $this->_contactService->getAllContacts();
        return new Response(
            $this->_serializer->serialize($contacts, 'json'),
            Response::HTTP_OK,
            ["Content-Type" => "application/json"]
        );
    }

    /**
     * Route to add contacts
     *
     * @param Request $request The request send by the client.
     *
     * @Route("/contacts")
     * @Method({"POST"})
     *
     * @return Response
     */
    public function addAction(Request $request)
    {
        $json = $request->getContent();
        $contactDto = $this->_serializer->deserialize(
            $json,
            'ContactBundle\DTO\ContactDto',
            'json'
        );

        $this->_contactService->createContact($contactDto);

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
     * @Route("/contacts/{id}", requirements={"id": "\d+"}) 
     * 
     * @return Response The response with a 204 NO CONTENT if everything is good
     *                  or an error instead.
     */
    public function deleteAction($id)
    {
        $this->_contactService->deleteContact($id);

        return new Response(
            '', 
            Response::HTTP_NO_CONTENT, 
            ['Content-Type' => 'application/json']
        );
    }
}
