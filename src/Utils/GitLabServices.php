<?php
/**
 * Created by PhpStorm.
 * User: codygrant
 * Date: 2018-04-07
 * Time: 12:58 PM
 */

namespace App\Utils;

use App\Entity\Task;
use Gitlab\Client;
use Doctrine\ORM\EntityManagerInterface;
use DateTime;

class GitLabServices
{
    private $token;
    private $client;
    private $em;

    public function __construct($token, Client $client, EntityManagerInterface $em) {
        $this->token = $token;
        $this->client = $client;
        $this->em = $em;
    }

    public function populateIssues() {
        $this->client = $this->client::create('https://gitlab.com')
            ->authenticate($this->token, $this->client::AUTH_URL_TOKEN);
        // pull all open issues
        $issues = $this->client->api('issues')->all(null, ['state'=>'opened']);

        foreach ($issues as $issue) {
            // find matching issue in DB
            $repository = $this->em->getRepository(Task::class);
            $task = $repository->findOneBy([
                'source' => 'gitlab',
                'task_id' => $issue['id'],
            ]);
            // update task in DB if issue has recent activity
            if ($task && $issue['updated_at'] > $task->getLastUpdated()) {
                $this->buildTask($task, $issue);
                $this->em->flush();
            } elseif (!$task) {
                $task = new Task();
                $this->buildTask($task, $issue);
                // save to db
                $this->em->persist($task);
                $this->em->flush();
            }
        }
    }

    public function buildTask(Task $current_task, $issue) {
        // use API to get project
        $project = $this->client->api('projects')->show($issue['project_id']);

        // set list as default then see if it matches others
        $task_list = 'Backlog';
        foreach ($issue['labels'] as $label) {
            if ($label == 'To Do') {
                $task_list = $label;
            } elseif ($label == 'Doing') {
                $task_list = $label;
            }
        }
        // build task
        $current_task->setTaskId($issue['id']);
        $current_task->setSource('gitlab');
        $current_task->setProject($project['name']);
        $current_task->setTitle($issue['title']);
        $current_task->setList($task_list);
        $current_task->setUrl($issue['web_url']);
        $current_task->setDescription($issue['description']);
        $current_task->setLastUpdated(new DateTime($issue['updated_at']));
        if ($issue['due_date'] != null) {
            $current_task->setDueDate(new DateTime($issue['due_date']));
        }
    }
}
