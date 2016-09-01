<?php

namespace Berriart\Bundle\SitemapBundle\Manager;

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

use Berriart\Bundle\SitemapBundle\Entity\Url;
use Berriart\Bundle\SitemapBundle\Repository\UrlRepositoryInterface;

class Sitemap
{
    private $repository;
    private $page;
    private $limit;

    public function __construct(UrlRepositoryInterface $repository, $limit, $multidomain, $baseUrl)
    {
        $this->repository = $repository;
        $this->page = 1;
        $this->limit = $limit;
        $this->isMultidomain = $multidomain;
        $this->baseUrl = $baseUrl;
    }

    public function add(Url $url)
    {
        $this->repository->add($url);
    }

    public function remove(Url $url)
    {
        return $this->repository->remove($url);
    }

    public function all()
    {
        return $this->repository->findAllOnPage($this->page, $this->limit, $this->isMultidomain, $this->baseUrl);
    }

    public function get($loc)
    {
        return $this->repository->findOneByLoc($loc);
    }

    public function pages()
    {
        return $this->repository->pages($this->limit, $this->isMultidomain, $this->baseUrl);
    }

    public function setPage($page)
    {
        $this->page = $page;
    }

    public function getPage()
    {
        return $this->page;
    }

    public function save()
    {
        $this->repository->flush();
    }

}
