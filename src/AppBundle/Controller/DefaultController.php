<?php
/**
 * File for the default Controller containing the root routes.
 *
 * PHP version 7.1
 *
 * @category Root
 * @package  AppBundle
 * @author   Yoann Fleury <yoann.fleury@yahoo.com>
 * @license  MIT License
 * @link     /
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Default Controller containing the root routes.
 *
 * @category Root
 * @package  AppBundle
 * @author   Yoann Fleury <yoann.fleury@yahoo.com>
 * @license  MIT License
 * @link     /
 */
class DefaultController extends Controller
{
    /**
     * The root of the API.
     *
     * @param Request $request The request made by an agent.
     *
     * @Route("/", name="homepage")
     *
     * @return Response
     */
    public function indexAction(Request $request)
    {
        return $this->render(
            'default/index.html.twig', 
            ['base_dir' => realpath($this->getParameter('kernel.project_dir'))
                .DIRECTORY_SEPARATOR]
        );
    }
}
