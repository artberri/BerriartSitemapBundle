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
        $entityManager = $this->getEntityManager();
        $entityManager->persist($url);
        $this->scheduleForCleanup($url);
    }

    public function findAllOnPage($page, $limit = self::LIMIT, $isMultidomain = false, $baseUrl = '')
    {
        $whereClause = $this->getWhereClause($isMultidomain);
        $entityManager = $this->getEntityManager();
        $maxResults = $limit;
        $firstResult = $maxResults * ($page - 1);
        $query = $entityManager->createQuery('SELECT u FROM BerriartSitemapBundle:Url u ' . $whereClause . ' ORDER BY u.id ASC')
            ->setFirstResult($firstResult)
            ->setMaxResults($maxResults);
        $query = $this->setWhereParameter($query, $isMultidomain, $baseUrl);
        $results = $query->getResult();

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
        $entityManager = $this->getEntityManager();
        $entityManager->remove($url);
        $this->scheduleForCleanup($url);
    }

    public function pages($limit = self::LIMIT, $isMultidomain = false, $baseUrl = '')
    {
        return max(ceil($this->countAll($isMultidomain, $baseUrl) / $limit), 1);
    }

    public function flush()
    {
        $entityManager = $this->getEntityManager();
        $entityManager->flush();
        $this->cleanup();
    }

    private function scheduleForCleanup(Url $url)
    {
        $this->urlsToRemove[] = $url;
    }

    private function cleanup()
    {
        $entityManager = $this->getEntityManager();
        foreach ($this->urlsToRemove as $url) {
            $entityManager->detach($url);
        }
        $this->urlsToRemove = array();
    }

    private function countAll($isMultidomain, $baseUrl)
    {
        $whereClause = $this->getWhereClause($isMultidomain);
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery('SELECT COUNT(u) FROM BerriartSitemapBundle:Url u ' . $whereClause);
        $query = $this->setWhereParameter($query, $isMultidomain, $baseUrl);
        $results = $query->getSingleResult();

        return $results[1];
    }

    private function getWhereClause($isMultidomain)
    {
        $whereClause = '';

        if ($isMultidomain) {
            $whereClause = 'WHERE u.loc LIKE :baseurl';
        }

        return $whereClause;
    }

    private function setWhereParameter($query, $isMultidomain, $baseUrl)
    {
        if ($isMultidomain) {
            $query = $query->setParameter('baseurl', $baseUrl . '%');
        }

        return $query;
    }
}
