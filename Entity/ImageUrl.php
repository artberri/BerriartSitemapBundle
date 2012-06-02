<?php

namespace Berriart\Bundle\SitemapBundle\Entity;

/**
 * This file is part of the BerriartSitemapBundle package what is based on the
 * AvalancheSitemapBundle
 *
 * (c) Bulat Shakirzyanov <avalanche123.com>
 * (c) Alberto Varela <alberto@berriart.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Doctrine\ORM\Mapping as ORM;

/**
 * Berriart\Bundle\SitemapBundle\Entity\ImageUrl
 */
class ImageUrl
{
    /**
     * @var integer $id
     */
    protected $id;
    
    /**
     * @var string $loc
     */
    protected $loc;
    
    /**
     * @var string $caption
     */
    protected $caption;
    
    /**
     * @var string $geoLocation
     */
    protected $geoLocation;
    
    /**
     * @var string $title
     */
    protected $title;
    
    /**
     * @var string $license
     */
    protected $license;
    
    /**
     * @var \Berriart\Bundle\SitemapBundle\Entity\Url $url
     */
    protected $url;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set loc
     *
     * @param string $loc
     */
    public function setLoc($loc)
    {
        $this->loc = $loc;
    }

    /**
     * Get loc
     *
     * @return string 
     */
    public function getLoc()
    {
        return $this->loc;
    }

    /**
     * Set caption
     *
     * @param string $caption
     */
    public function setCaption($caption)
    {
        $this->caption = $caption;
    }

    /**
     * Get caption
     *
     * @return string 
     */
    public function getCaption()
    {
        return $this->caption;
    }

    /**
     * Set geoLocation
     *
     * @param string $geoLocation
     */
    public function setGeoLocation($geoLocation)
    {
        $this->geoLocation = $geoLocation;
    }

    /**
     * Get geoLocation
     *
     * @return string 
     */
    public function getGeoLocation()
    {
        return $this->geoLocation;
    }

    /**
     * Set title
     *
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set license
     *
     * @param string $license
     */
    public function setLicense($license)
    {
        $this->license = $license;
    }

    /**
     * Get license
     *
     * @return string 
     */
    public function getLicense()
    {
        return $this->license;
    }

    /**
     * Set url
     *
     * @param \Berriart\Bundle\SitemapBundle\Entity\Url $url
     */
    public function setUrl(\Berriart\Bundle\SitemapBundle\Entity\Url $url)
    {
        $this->url = $url;
    }

    /**
     * Get url
     *
     * @return \Berriart\Bundle\SitemapBundle\Entity\Url
     */
    public function getUrl()
    {
        return $this->url;
    }
}