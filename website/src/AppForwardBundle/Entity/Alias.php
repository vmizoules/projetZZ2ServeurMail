<?php

namespace AppForwardBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class Alias
{
    private $address;
    private $user_id;
    private $site;
    private $url;
    /**
     * @var \DateTime
     */
    private $created;
    /**
     * @var \DateTime
     */
    private $modified;
    private $enabled = 1; // activated by default

    /**
     * @return mixed
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * @param mixed $enabled
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param mixed $user_id
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * @return mixed
     */
    public function getSite()
    {
        return $this->site;
    }

    /**
     * @param mixed $site
     */
    public function setSite($site)
    {
        $this->site = $site;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @return string
     */
    public function getCreatedString()
    {
        return $this->created->format('Y-m-d H:i:s');
    }


    /**
     * @param \DateTime $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

    /**
     * @return \DateTime
     */
    public function getModified()
    {
        return $this->modified;
    }

    /**
     * @return string
     */
    public function getModifiedString()
    {
        return $this->modified->format('Y-m-d H:i:s');
    }

    /**
     * @param \DateTime $modified
     */
    public function setModified($modified)
    {
        $this->modified = $modified;
    }
}
