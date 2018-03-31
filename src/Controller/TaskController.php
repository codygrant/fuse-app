<?php
/**
 * Created by PhpStorm.
 * User: codygrant
 * Date: 2018-03-18
 * Time: 6:39 PM
 */

namespace App\Controller;

use App\Entity\Task;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Doctrine\ORM\EntityManagerInterface;

class TaskController extends Controller {

    private $session;
    private $em;

    public function __construct(SessionInterface $session, EntityManagerInterface $em) {
        $this->session = $session;
        $this->em = $em;
    }

    /**
     * @return Response
     * @Route("/")
     */
    public function index() {
        $tasks = $this->em->getRepository(Task::class)->findAll();
        return $this->render('home.html.twig', array('tasks' => $tasks));
    }
}