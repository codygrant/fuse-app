<?php
/**
 * Created by PhpStorm.
 * User: codygrant
 * Date: 2018-03-18
 * Time: 6:39 PM
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class TaskController extends Controller {

    private $session;

    public function __construct(SessionInterface $session) {
        $this->session = $session;
    }

    /**
     * @return Response
     * @Route("/")
     */
    public function index() {
        return $this->render('home.html.twig');
    }
}