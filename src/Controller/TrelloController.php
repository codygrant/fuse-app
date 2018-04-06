<?php
/**
 * Created by PhpStorm.
 * User: codygrant
 * Date: 2018-03-18
 * Time: 6:28 PM
 */

namespace App\Controller;

use App\Utils\TrelloServices;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use League\OAuth1\Client\Server\Trello;
use Trello\Exception\RuntimeException;

/**
 * @Route("/trello")
 */
class TrelloController extends Controller
{

    private $session;

    public function __construct(SessionInterface $session) {
        $this->session = $session;
    }

    /**
     * @Route("/authenticate")
     * @param Request $request
     * @param Trello $server
     * @return Response
     */
    public function authenticate(Request $request, Trello $server) {

        if ($request->query->has('oauth_token')) {
            // authenticate user
            $token = $request->query->get('oauth_token');
            $verifier = $request->query->get('oauth_verifier');
            $temp_credentials = $this->get('session')->get('temporary_credentials');
            $token_creds = $server->getTokenCredentials($temp_credentials, $token, $verifier);
            $this->session->set('trello_object', $token_creds);
            $this->session->set('trello_token', $token_creds->getIdentifier());
            $this->session->set('trello_user', $server->getUserDetails($token_creds));
            return $this->redirect($this->generateUrl('app_trello_sync'));
        } else {
            // create the temp credentials and ask for access
            $temp_credentials = $server->getTemporaryCredentials();
            $this->session->set('temporary_credentials', $temp_credentials);
            $server->authorize($temp_credentials);
            $auth_url = $server->getAuthorizationUrl($temp_credentials);
            return $this->redirect($auth_url);
        }
    }

    /**
     * @Route("/sync")
     */
    public function sync(TrelloServices $services) {
        try {
            $services->populateCards();
            return $this->redirectToRoute('app_task_index');
        } catch (RuntimeException $ex) {
            return $this->redirectToRoute('app_trello_authenticate');
        }
    }
}
