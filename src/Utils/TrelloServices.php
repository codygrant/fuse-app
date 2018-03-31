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
use Doctrine\ORM\EntityManagerInterface;
use DateTime;

class TrelloServices {

    private $api_key;
    private $client;
    private $session;
    private $em;

    public function __construct($api_key, Client $client, SessionInterface $session, EntityManagerInterface $em) {
        $this->api_key = $api_key;
        $this->client = $client;
        $this->session = $session;
        $this->em = $em;
    }

    public function populate_cards() {
        // build the client object
        $token = $this->session->get('trello_token');
        $resource_owner = $this->session->get('trello_user');
        $this->client->authenticate($this->api_key, $token, Client::AUTH_URL_CLIENT_ID);

        // get all cards
        $cards = $this->client->api('member')->cards()->all($resource_owner->nickname);

        foreach ($cards as $card) {

            // pull matching card from DB and check date of last activity
            $repository = $this->em->getRepository(Task::class);
            $entity = $repository->findOneBy([
                'source' => 'trello',
                'task_id' => $card['id'],
            ]);

            // don't update card if activity hasn't changed
            $card_activity = new DateTime($card['dateLastActivity']);
            if ($entity != null && $card_activity <= $entity->getLastUpdated())
                continue;

            // use API to get board, list name from ID
            $list = $this->client->api('lists')->show($card['idList']);
            $project = $this->client->api('boards')->show($card['idBoard']);

            $task = new Task();
            $task->setTaskId($card['id']);
            $task->setSource('trello');
            $task->setProject($project['name']);
            $task->setTitle($card['name']);
            $task->setList($list['name']);
            $task->setUrl($card['shortUrl']);
            $task->setDescription($card['desc']);
            $task->setLastUpdated(new DateTime($card['dateLastActivity']));
            if ($card['due'] != null)
                $task->setDueDate(new DateTime($card['due']));

            // save to db
            $this->em->persist($task);
            $this->em->flush();
        }
    }
}