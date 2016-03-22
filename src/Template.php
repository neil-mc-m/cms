<?php

namespace CMS;

/**
 * A template class to help in the generation of twig templates.
 */
class Template
{
    /**
     * template id.
     *
     * @var int
     */
    public $id;
    /**
     * template name.
     *
     * @var string
     */
    public $templatename;
    /**
     * content for a template.
     *
     * @var string. should be a twig statement. eg {% extends 'base.html.twig' %}
     */
    public $templatecontent;
    /**
     * date created.
     *
     * @var date
     */
    public $created;

    //////////// GETTERS ///////////////////
    /**
     * Get the value of Id.
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of Templatename.
     *
     * @return mixed
     */
    public function getTemplatename()
    {
        return $this->templatename;
    }

    /**
     * Get the value of Templatecontent.
     *
     * @return mixed
     */
    public function getTemplatecontent()
    {
        return $this->templatecontent;
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

    /////////////// SETTERS ///////////////////
    /**
     * Set the value of Id.
     *
     * @param mixed id
     *
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Set the value of Templatename.
     *
     * @param mixed templatename
     *
     * @return self
     */
    public function setTemplatename($templatename)
    {
        $this->templatename = $templatename;

        return $this;
    }

    /**
     * Set the value of Templatecontent.
     *
     * @param mixed templatecontent
     *
     * @return self
     */
    public function setTemplatecontent($templatecontent)
    {
        $this->templatecontent = $templatecontent;

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
}
