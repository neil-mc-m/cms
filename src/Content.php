<?php

namespace CMS;

class Content
{
    public $contentId;
    public $pageName;
    public $contentType;
    public $contentItemTitle;
    public $contentItem;
    public $imagePath;
    public $created;
    public $modified;

    /**
     * Get the value of Contentid.
     *
     * @return mixed
     */
    public function getContentId()
    {
        return $this->contentId;
    }

    /**
     * Get the value of Pagename.
     *
     * @return mixed
     */
    public function getPageName()
    {
        return $this->pageName;
    }

    /**
     * Get the value of Contenttype.
     *
     * @return mixed
     */
    public function getContentType()
    {
        return $this->contentType;
    }

    /**
     * Get the value of Contentitemtitle.
     *
     * @return mixed
     */
    public function getContentItemTitle()
    {
        return $this->contentItemTitle;
    }

    /**
     * Get the value of Contentitem.
     *
     * @return mixed
     */
    public function getContentItem()
    {
        return $this->contentItem;
    }

    /**
     * Get the value of imagePath.
     * 
     * @return mixed
     */
    public function getImagePath()
    {
        return $this->imagePath;
    }

    /**
     * Get the value of Created.
     *
     * @return mixed
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Gets the value of modified.
     *
     * @return mixed
     */
    public function getModified()
    {
        return $this->modified;
    }

    /**
     * Set the value of Contentid.
     *
     * @param mixed contentid
     *
     * @return self
     */
    public function setContentId($contentId)
    {
        $this->contentId = $contentId;

        return $this;
    }

    /**
     * Set the value of Pagename.
     *
     * @param mixed pagename
     *
     * @return self
     */
    public function setPageName($pageName)
    {
        $this->pageName = $pageName;

        return $this;
    }

    /**
     * Set the value of Contenttype.
     *
     * @param mixed contenttype
     *
     * @return self
     */
    public function setContentType($contentType)
    {
        $this->contentType = $contentType;

        return $this;
    }

    /**
     * Set the value of Contentitemtitle.
     *
     * @param mixed contentitemtitle
     *
     * @return self
     */
    public function setContentItemTitle($contentItemTitle)
    {
        $this->contentItemTitle = $contentItemTitle;

        return $this;
    }

    /**
     * Set the value of Contentitem.
     *
     * @param mixed contentitem
     *
     * @return self
     */
    public function setContentItem($contentItem)
    {
        $this->contentItem = $contentItem;

        return $this;
    }

    /**
     * Set the image path.
     * 
     * @param mixed imagePath
     * 
     * @return self
     */
    public function setImagePath($imagePath)
    {
        $this->imagePath = $imagePath;

        return $this;
    }
    /**
     * Set the value of Created.
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

    /**
     * Set the value for modified.
     * 
     * @param mixed modified
     * 
     * @return self
     */
    public function setModified($modified)
    {
        $this->modified = $modified;

        return $this;
    }
}
