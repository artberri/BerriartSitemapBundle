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
 * Berriart\Bundle\SitemapBundle\Entity\Url
 */
class Url
{
    /**
     * Change Frequency Type Constants 
     */
    const CHANGEFREQ_ALWAYS = 'always';
    const CHANGEFREQ_HOURLY = 'hourly';
    const CHANGEFREQ_DAILY = 'daily';
    const CHANGEFREQ_WEEKLY = 'weekly';
    const CHANGEFREQ_MONTHLY = 'monthly';
    const CHANGEFREQ_YEARLY = 'yearly';
    const CHANGEFREQ_NEVER = 'never';
    
    /**
     * @var integer $id
     */
    protected $id;
    
    /**
     * @var string $loc
     */
    protected $loc;
    
    /**
     * @var \DateTime $lastmod
     */
    protected $lastmod;
    
    /**
     * @var string $changefreq
     */
    protected $changefreq;
    
    /**
     * @var float $priority
     */
    protected $priority;
    
    /**
     * @var array $images
     */
    protected $images;

    /**
     * Constructor 
     */
    public function __construct()
    {
        $this->images = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set lastmod
     *
     * @param \DateTime $lastmod
     */
    public function setLastmod($lastmod)
    {
        $this->lastmod = $lastmod;
    }

    /**
     * Get lastmod
     *
     * @return \DateTime
     */
    public function getLastmod()
    {
        return $this->lastmod;
    }

    /**
     * Set changefreq
     *
     * @param string $changefreq
     */
    public function setChangefreq($changefreq)
    {
        $this->changefreq = $changefreq;
    }

    /**
     * Get changefreq
     *
     * @return string 
     */
    public function getChangefreq()
    {
        return $this->changefreq;
    }

    /**
     * Set priority
     *
     * @param float $priority
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;
    }

    /**
     * Get priority
     *
     * @return float 
     */
    public function getPriority()
    {
        return $this->priority;
    }
    
    /**
     * Add images
     *
     * @param \Berriart\Bundle\SitemapBundle\Entity\ImageUrl $images
     */
    public function addImageUrl(\Berriart\Bundle\SitemapBundle\Entity\ImageUrl $images)
    {
        $this->images[] = $images;
    }

    /**
     * Get images
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getImages()
    {
        return $this->images;
    }
}