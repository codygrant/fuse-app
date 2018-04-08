<?php
/**
 * Created by PhpStorm.
 * User: codygrant
 * Date: 2018-04-07
 * Time: 12:36 PM
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use App\Utils\GitLabServices;

/**
 * Class GitLabController
 * @package App\Controller
 * @Route("/gitlab")
 */
class GitLabController extends Controller
{
    private $services;

    public function __construct(GitLabServices $services) {
        $this->services = $services;
    }

    /**
     * @Route("/sync")
     */
    public function sync() {
        $this->services->populateIssues();
        return $this->redirectToRoute('app_task_index');
    }
}