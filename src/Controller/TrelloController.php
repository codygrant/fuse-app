<?php
/**
 * Created by PhpStorm.
 * User: codygrant
 * Date: 2018-03-18
 * Time: 6:28 PM
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use League\OAuth1\Client\Server\Trello;

/**
 * @Route("/trello")
 */
class TrelloController extends Controller {

    private $session;

    public function __construct(SessionInterface $session) {
        $this->session = $session;
    }

    /**
     * @Route("/authenticate")
     */
    public function authenticate(Request $request, Trello $server) {

        // Check for query parameter then authenticate
        if ($request->query->has('oauth_token')) {

            $token = $request->query->get('oauth_token');
            $verifier = $request->query->get('oauth_verifier');
            $tempCredentials = $this->get('session')->get('temporary_credentials');
            $tokenCredentials = $server->getTokenCredentials($tempCredentials, $token, $verifier);
            $this->session->set('trello_object', $tokenCredentials);
            $this->session->set('trello_token', $tokenCredentials->getIdentifier());
            return $this->redirect($this->generateUrl('app_task_index'));
        }
        // create the temp credentials and ask for access
        else {
            $tempCredentials = $server->getTemporaryCredentials();
            $this->session->set('temporary_credentials', $tempCredentials);
            $server->authorize($tempCredentials);
            $authorizationUrl = $server->getAuthorizationUrl($tempCredentials);
            return $this->redirect($authorizationUrl);
        }
    }
}