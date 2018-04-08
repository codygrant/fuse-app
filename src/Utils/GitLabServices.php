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
    }
}
