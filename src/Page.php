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
     * @var integer
     */
    public $pageId;
    /**
     * The name of the page eg home.
     * @var string
     */
    public $pageName;

    /**
     * the path to the page eg /home.
     * @var string
     */
    public $pagePath;

    /**
     * the template to return eg home.html.twig.
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
     * Get the value of the path to the page eg /home.
     *
     * @return string
     */
    public function getPagePath()
    {
        return $this->pagePath;
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
     * Set the value of the path to the page eg /home.
     *
     * @param string pagePath
     *
     * @return self
     */
    public function setPagePath($pagePath)
    {
        $this->pagePath = $pagePath;

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

    public function getAllNames()
    {
        
    }

}
