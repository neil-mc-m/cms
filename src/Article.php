<?php

namespace CMS;

class Article
{
    public $contentid;
    public $contenttype;
    public $articletitle;
    public $paragraphtitle;
    public $paragraphbody;
    public $created;


    /**
     * Gets the value of contentid.
     *
     * @return mixed
     */
    public function getContentid()
    {
        return $this->contentid;
    }

    /**
     * Sets the value of contentid.
     *
     * @param mixed $contentid the contentid
     *
     * @return self
     */
    public function setContentid($contentid)
    {
        $this->contentid = $contentid;

        return $this;
    }

    /**
     * Gets the value of contenttype.
     *
     * @return mixed
     */
    public function getContenttype()
    {
        return $this->contenttype;
    }

    /**
     * Sets the value of contenttype.
     *
     * @param mixed $contenttype the contenttype
     *
     * @return self
     */
    public function setContenttype($contenttype)
    {
        $this->contenttype = $contenttype;

        return $this;
    }

    /**
     * Gets the value of articletitle.
     *
     * @return mixed
     */
    public function getArticletitle()
    {
        return $this->articletitle;
    }

    /**
     * Sets the value of articletitle.
     *
     * @param mixed $articletitle the articletitle
     *
     * @return self
     */
    public function setArticletitle($articletitle)
    {
        $this->articletitle = $articletitle;

        return $this;
    }

    /**
     * Gets the value of paragraphtitle.
     *
     * @return mixed
     */
    public function getParagraphtitle()
    {
        return $this->paragraphtitle;
    }

    /**
     * Sets the value of paragraphtitle.
     *
     * @param mixed $paragraphtitle the paragraphtitle
     *
     * @return self
     */
    public function setParagraphtitle($paragraphtitle)
    {
        $this->paragraphtitle = $paragraphtitle;

        return $this;
    }

    /**
     * Gets the value of paragraphbody.
     *
     * @return mixed
     */
    public function getParagraphbody()
    {
        return $this->paragraphbody;
    }

    /**
     * Sets the value of paragraphbody.
     *
     * @param mixed $paragraphbody the paragraphbody
     *
     * @return self
     */
    public function setParagraphbody($paragraphbody)
    {
        $this->paragraphbody = $paragraphbody;

        return $this;
    }

    /**
     * Gets the value of created.
     *
     * @return mixed
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Sets the value of created.
     *
     * @param mixed $created the created
     *
     * @return self
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }
}
