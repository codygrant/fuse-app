<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TaskRepository")
 */
class Task
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column(type="string")
     */
    private $task_id;
    /**
     * @ORM\Column(type="string")
     */
    private $source;
    /**
     * @ORM\Column(type="string")
     */
    private $project;
    /**
     * @ORM\Column(type="string")
     */
    private $title;
    /**
     * @ORM\Column(type="string")
     */
    private $list;
    /**
     * @ORM\Column(type="string")
     */
    private $url;
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $status;
    /**
     * @ORM\Column(type="string", length=16384, nullable=true)
     */
    private $description;
    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $due_date;
    /**
     * @ORM\Column(type="datetime")
     */
    private $last_updated;

    /**
     * Get id
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Get task_id
     * @return string
     */
    public function getTaskId() {
        return $this->task_id;
    }

    /**
     * Set task_id
     * @return $this
     * @param string
     */
    public function setTaskId(string $task_id) {
        $this->task_id = $task_id;
        return $this;
    }

    /**
     * Get source
     * @return string
     */
    public function getSource() {
        return $this->source;
    }

    /**
     * Set source
     * @return $this
     * @param string
     */
    public function setSource(string $source) {
        $this->source = $source;
        return $this;
    }

    /**
     * Get project
     * @return string
     */
    public function getProject() {
        return $this->project;
    }

    /**
     * Set project
     * @return $this
     * @param string
     */
    public function setProject(string $project) {
        $this->project = $project;
        return $this;
    }

    /**
     * Get title
     * @return string
     */
    public function getTitle() {
        return $this->title;
    }
    /**
     * Set title
     * @return $this
     * @param string
     */
    public function setTitle(string $title) {
        $this->title = $title;
        return $this;
    }

    /**
     * Get list
     * @return string
     */
    public function getList() {
        return $this->list;
    }
    /**
     * Set list
     * @return $this
     * @param string
     */
    public function setList(string $list) {
        $this->list = $list;
        return $this;
    }

    /**
     * Get URL
     * @return string
     */
    public function getUrl() {
        return $this->url;
    }
    /**
     * Set URL
     * @return $this
     * @param string
     */
    public function setUrl(string $url) {
        $this->url = $url;
        return $this;
    }

    /**
     * Get status
     * @return string
     */
    public function getStatus() {
        return $this->status;
    }
    /**
     * Set status
     * @return $this
     * @param string
     */
    public function setStatus(string $status) {
        $this->status = $status;
        return $this;
    }

    /**
     * Get description
     * @return string
     */
    public function getDescription() {
        return $this->url;
    }
    /**
     * Set description
     * @return $this
     * @param string
     */
    public function setDescription(string $description) {
        $this->description = $description;
        return $this;
    }

    /**
     * Get due_date
     * @return \DateTime
     */
    public function getDueDate() {
        return $this->due_date;
    }
    /**
     * Set due_date
     * @return $this
     * @param \DateTime
     */
    public function setDueDate(\DateTime $due_date) {
        $this->due_date = $due_date;
        return $this;
    }

    /**
     * Get last_updated
     * @return \DateTime
     */
    public function getLastUpdated() {
        return $this->last_updated;
    }
    /**
     * Set last_updated
     * @return $this
     * @param \DateTime
     */
    public function setLastUpdated(\DateTime $last_updated) {
        $this->last_updated = $last_updated;
        return $this;
    }
}
