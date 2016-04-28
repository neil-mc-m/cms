<?php

namespace CMS;

/**
 * An image class to handle uploading of images.
 * 
 * It can also associate an image with an article or
 * piece of content.
 * 
 * @Class Image
 */
class Image
{
    /**
     * The image id.
     * 
     * @var int.
     */
    public $id;

    /**
     * The contentId the image is connected to.
     * 
     * @var int
     */
    public $contentId;

    /**
     * The path to the image.
     * 
     * @var string
     */
    public $imagePath;

    /**
     * Gets the value of id.
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets the value of id.
     *
     * @param mixed $id the id
     *
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Gets the value of contentId.
     *
     * @return mixed
     */
    public function getContentId()
    {
        return $this->contentId;
    }

    /**
     * Sets the value of contentId.
     *
     * @param mixed $contentId the content id
     *
     * @return self
     */
    public function setContentId($contentId)
    {
        $this->contentId = $contentId;

        return $this;
    }

    /**
     * Gets the value of path.
     *
     * @return mixed
     */
    public function getImagePath()
    {
        return $this->path;
    }

    /**
     * Sets the value of path.
     *
     * @param mixed $path the path
     *
     * @return self
     */
    public function setImagePath($path)
    {
        $this->path = '/images/'.$path.'" class="img-resp" alt="'.str_replace('.jpg', '_pic', $path);

        return $this;
    }
}
