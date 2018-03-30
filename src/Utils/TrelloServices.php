<?php
/**
 * Created by PhpStorm.
 * User: codygrant
 * Date: 2018-03-25
 * Time: 5:05 PM
 */

namespace App\Utils;

use App\Entity\Task;
use Trello\Client;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use DateTime;

class TrelloServices {

    private $api_key;
    private $client;
    private $session;

    public function __construct($api_key, Client $client, SessionInterface $session) {
        $this->api_key = $api_key;
        $this->client = $client;
        $this->session = $session;
    }

    public function buildList() {
        // build the client object
        $token = $this->session->get('trello_token');
        $resource_owner = $this->session->get('trello_user');
        $this->client->authenticate($this->api_key, $token, Client::AUTH_URL_CLIENT_ID);

        // get all cards
        $cards = $this->client->api('member')->cards()->all($resource_owner->nickname);

        $tasks = [];
        foreach ($cards as $card) {
            // use API to get board, list name from ID
            $list = $this->client->api('lists')->show($card['idList']);
            $project = $this->client->api('boards')->show($card['idBoard']);

            $task = new Task();
            $task->setSource('trello');
            $task->setProject($project['name']);
            $task->setTitle($card['name']);
            $task->setList($list['name']);
            $task->setUrl($card['shortUrl']);
            $task->setDescription($card['desc']);
            if ($card['due'] != null)
                $task->setDueDate(new DateTime($card['due']));
            $tasks[] = $task;
        }
        return $tasks;
    }
}