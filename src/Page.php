<?php

namespace LightCMS;

/**
 * a class for web pages.
 */

/**
 * This class will be used for generating webpages.
 *
 * @Class Page
 */
class Page
{
    /**
     * an id.
     *
     * @var int
     */
    public $pageid;
    /**
     * The name of the page eg home.
     *
     * @var string
     */
    public $pagename;

    /**
     * the path to the page eg /home.
     *
     * @var string
     */
    public $pagepath;

    /**
     * the template to return eg home.html.twig.
     *
     * @var string
     */
    public $pagetemplate;

    /////////////Getters////////////////
    /**
     * Get the value of The name of the page eg home.
     *
     * @return string
     */
    public function getPageName()
    {
        return $this->pagename;
    }

    /**
     * Get the value of the path to the page eg /home.
     *
     * @return string
     */
    public function getPagePath()
    {
        return $this->pagepath;
    }

    /**
     * Get the value of the template to return eg home.html.twig.
     *
     * @return string
     */
    public function getPageTemplate()
    {
        return $this->pagetemplate;
    }

    ////////////setters//////////////////
    /**
     * Set the value of The name of the page eg home.
     *
     * @param string pageName
     *
     * @return self
     */
    public function setPageName($pagename)
    {
        $this->pagename = $pagename;

        return $this;
    }

    /**
     * Set the value of the path to the page eg /home.
     *
     * @param string pagePath
     *
     * @return self
     */
    public function setPagePath($pagepath)
    {
        $this->pagepath = $pagepath;

        return $this;
    }

    /**
     * Set the value of the template to return eg home.html.twig.
     *
     * @param string pageTemplate
     *
     * @return self
     */
    public function setPageTemplate($pagetemplate)
    {
        $this->pagetemplate = $pagetemplate;

        return $this;
    }

    public function getAllNames()
    {
    }
}
