<?php

namespace CMS;

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
    public $pageId;
    /**
     * The name of the page eg home.
     *
     * @var string
     */
    public $pageName;

    /**
     * A route generated from the pageName variable.
     * 
     * @var string
     */
    public $pageRoute;

    /**
     * the template to return eg home.html.twig.
     *
     * @var string
     */
    public $pageTemplate;

    /////////////Getters////////////////
    /**
     * Get the value of The name of the page eg home.
     *
     * @return string
     */
    public function getPageName()
    {
        return $this->pageName;
    }
    /**
     * Get the pageRoute from the pageName variable.
     * 
     * @return string
     */
    public function getPageRoute()
    {
        return $this->pageRoute;
    }
    /**
     * Get the value of the template to return eg home.html.twig.
     *
     * @return string
     */
    public function getPageTemplate()
    {
        return $this->pageTemplate;
    }

    ////////////setters//////////////////
    /**
     * Set the value of The name of the page eg home.
     *
     * @param string pageName
     *
     * @return self
     */
    public function setPageName($pageName)
    {
        $this->pageName = $pageName;

        return $this;
    }

    /**
     * Set the value for the page route and replace spaces with dashes.
     * 
     * @param string pageRoute
     * 
     * @return self
     */
    public function setPageRoute($pageName)
    {
        $this->pageRoute = strtolower(str_replace(' ', '-', $pageName));

        return $this;
    }
    /**
     * Set the value of the template to return eg home.html.twig.
     *
     * @param string pageTemplate
     *
     * @return self
     */
    public function setPageTemplate($pageTemplate)
    {
        $this->pageTemplate = $pageTemplate;

        return $this;
    }
}
