<?php

namespace Berriart\Bundle\SitemapBundle\Repository;

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

use Doctrine\ORM\EntityRepository;
use Berriart\Bundle\SitemapBundle\Entity\Url;
use Berriart\Bundle\SitemapBundle\Repository\UrlRepositoryInterface;

/**
 * UrlRepository
 */
class UrlRepository extends EntityRepository implements UrlRepositoryInterface
{
    private $urlsToRemove = array();

    public function add(Url $url)
    {
        $em = $this->getEntityManager();
        $em->persist($url);
        $this->scheduleForCleanup($url);
    }

    public function findAllOnPage($page)
    {
        $em = $this->getEntityManager();
        $maxResults = UrlRepositoryInterface::LIMIT;
        $firstResult = UrlRepositoryInterface::LIMIT * ($page - 1);
        $results = $em->createQuery('SELECT u FROM BerriartSitemapBundle:Url u ORDER BY u.id ASC')
            ->setFirstResult($firstResult)
            ->setMaxResults($maxResults)
            ->getResult();
        
        return $results;
    }

    public function findOneByLoc($loc)
    {
        $url = $this->findOneBy(array('loc' => $loc));
        if (null !== $url) {
            $this->scheduleForCleanup($url);
        }
        
        return $url;
    }

    public function remove(Url $url)
    {
        $em = $this->getEntityManager();
        $em->remove($url);
        $this->scheduleForCleanup($url);
    }

    public function pages()
    {
        return max(ceil($this->countAll() / UrlRepositoryInterface::LIMIT), 1);
    }

    public function flush()
    {
        $em = $this->getEntityManager();
        $em->flush();
        $this->cleanup();
    }

    private function scheduleForCleanup(Url $url)
    {
        $this->urlsToRemove[] = $url;
    }

    private function cleanup()
    {
        $em = $this->getEntityManager();
        foreach ($this->urlsToRemove as $url) {
            $em->detach($url);
        }
        $this->urlsToRemove = array();
    }
    
    private function countAll()
    {
        $em = $this->getEntityManager();
        $results = $em->createQuery('SELECT COUNT(u) FROM BerriartSitemapBundle:Url u')
            ->getSingleResult();

        return $results[1];
    }
}