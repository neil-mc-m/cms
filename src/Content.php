<<?php
namespace LightCMS;

class Content
{
    public $contentid;
    public $pagename;
    public $contenttype;
    public $contentitemtitle;
    public $contentitem;
    public $created;



    /**
     * Get the value of Contentid
     *
     * @return mixed
     */
    public function getContentid()
    {
        return $this->contentid;
    }

    /**
     * Get the value of Pagename
     *
     * @return mixed
     */
    public function getPagename()
    {
        return $this->pagename;
    }

    /**
     * Get the value of Contenttype
     *
     * @return mixed
     */
    public function getContenttype()
    {
        return $this->contenttype;
    }

    /**
     * Get the value of Contentitemtitle
     *
     * @return mixed
     */
    public function getContentitemtitle()
    {
        return $this->contentitemtitle;
    }

    /**
     * Get the value of Contentitem
     *
     * @return mixed
     */
    public function getContentitem()
    {
        return $this->contentitem;
    }

    /**
     * Get the value of Created
     *
     * @return mixed
     */
    public function getCreated()
    {
        return $this->created;
    }


    /**
     * Set the value of Contentid
     *
     * @param mixed contentid
     *
     * @return self
     */
    public function setContentid($contentid)
    {
        $this->contentid = $contentid;

        return $this;
    }

    /**
     * Set the value of Pagename
     *
     * @param mixed pagename
     *
     * @return self
     */
    public function setPagename($pagename)
    {
        $this->pagename = $pagename;

        return $this;
    }

    /**
     * Set the value of Contenttype
     *
     * @param mixed contenttype
     *
     * @return self
     */
    public function setContenttype($contenttype)
    {
        $this->contenttype = $contenttype;

        return $this;
    }

    /**
     * Set the value of Contentitemtitle
     *
     * @param mixed contentitemtitle
     *
     * @return self
     */
    public function setContentitemtitle($contentitemtitle)
    {
        $this->contentitemtitle = $contentitemtitle;

        return $this;
    }

    /**
     * Set the value of Contentitem
     *
     * @param mixed contentitem
     *
     * @return self
     */
    public function setContentitem($contentitem)
    {
        $this->contentitem = $contentitem;

        return $this;
    }

    /**
     * Set the value of Created
     *
     * @param mixed created
     *
     * @return self
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

}
