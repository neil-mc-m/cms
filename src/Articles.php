<?php

namespace CMS;

class Articles
{
    /**
     * primary key.
     *
     * @var int
     */
    private $id;
    /**
     * article title.
     *
     * @var string
     */
    private $title;
    /**
     * an article.
     *
     * @var string
     */
    private $article;

    /**
     * date created.
     *
     * @var date
     */
    private $created;

    /**
     * Get the value of primary key.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of primary key.
     *
     * @param int id
     *
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of article title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the value of article title.
     *
     * @param string title
     *
     * @return self
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the value of an article.
     *
     * @return string
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * Set the value of an article.
     *
     * @param string article
     *
     * @return self
     */
    public function setArticle($article)
    {
        $this->article = $article;

        return $this;
    }

    /**
     * Get the value of date created.
     *
     * @return date
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set the value of date created.
     *
     * @param date created
     *
     * @return self
     */
    public function setCreated(date $created)
    {
        $this->created = $created;

        return $this;
    }
}
