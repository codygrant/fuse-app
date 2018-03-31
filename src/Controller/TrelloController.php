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
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use League\OAuth1\Client\Server\Trello;
use Trello\Exception\RuntimeException;

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
            $this->session->set('trello_user', $server->getUserDetails($tokenCredentials));
            return $this->redirect($this->generateUrl('app_trello_sync'));
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

    /**
     * @Route("/sync")
     */
    public function sync(TrelloServices $services) {
        try {
            $services->populate_cards();
            return $this->redirectToRoute('app_task_index');
        } catch (RuntimeException $ex) {
            return $this->redirectToRoute('app_trello_authenticate');
        }
    }
}