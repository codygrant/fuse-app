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

class TrelloServices
{
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

    public function populateCards() {
        // build the client object
        $token = $this->session->get('trello_token');
        $resource_owner = $this->session->get('trello_user');
        $this->client->authenticate($this->api_key, $token, Client::AUTH_URL_CLIENT_ID);

        // get all cards
        $cards = $this->client->api('member')->cards()->all($resource_owner->nickname);

        foreach ($cards as $current_card) {
            // pull matching card from DB and check date of last activity
            $repository = $this->em->getRepository(Task::class);
            $entity = $repository->findOneBy([
                'source' => 'trello',
                'task_id' => $current_card['id'],
            ]);

            // don't update card if activity hasn't changed
            $card_activity = new DateTime($current_card['dateLastActivity']);
            if ($entity && $card_activity > $entity->getLastUpdated()) {
                $this->buildTask($entity, $current_card);
                $this->em->flush();
            } elseif (!$entity) {
                $current_task = new Task();
                $this->buildTask($current_task, $current_card);
                // save to db
                $this->em->persist($current_task);
                $this->em->flush();
            }
        }
    }

    public function buildTask(Task $current_task, $current_card) {
        // use API to get board, list name from ID
        $card_list = $this->client->api('lists')->show($current_card['idList']);
        $project = $this->client->api('boards')->show($current_card['idBoard']);

        $current_task->setTaskId($current_card['id']);
        $current_task->setSource('trello');
        $current_task->setProject($project['name']);
        $current_task->setTitle($current_card['name']);
        $current_task->setList($card_list['name']);
        $current_task->setUrl($current_card['shortUrl']);
        $current_task->setDescription($current_card['desc']);
        $current_task->setLastUpdated(new DateTime($current_card['dateLastActivity']));
        if ($current_card['due'] != null) {
            $current_task->setDueDate(new DateTime($current_card['due']));
        }
    }
}
