<?php

namespace App\Entity;

class Task
{
    private $id;
    private $source;
    private $project;
    private $site_name;
    private $title;
    private $list;
    private $url;
    private $status;
    private $description;
    private $due_date;

    /**
     * Get id
     */
    public function getId() {
        return $this->id;
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
        return $this->source;
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
     * Get site_name
     * @return string
     */
    public function getSiteName() {
        return $this->site_name;
    }
    /**
     * Set site_name
     * @return $this
     * @param string
     */
    public function setSiteName(string $site_name) {
        $this->site_name = $site_name;
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
}
