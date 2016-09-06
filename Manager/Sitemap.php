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

use Symfony\Component\HttpFoundation\RequestStack;
use Berriart\Bundle\SitemapBundle\Entity\Url;
use Berriart\Bundle\SitemapBundle\Repository\UrlRepositoryInterface;

class Sitemap
{
    protected $requestStack;
    protected $repository;
    protected $page;
    protected $limit;
    protected $isMultidomain;
    protected $baseUrl;

    public function __construct(RequestStack $requestStack, UrlRepositoryInterface $repository, $limit, $multidomain)
    {
        $this->requestStack = $requestStack;
        $this->repository = $repository;
        $this->page = 1;
        $this->limit = $limit;
        $this->isMultidomain = $multidomain;
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
        return $this->repository->findAllOnPage($this->page, $this->limit, $this->isMultidomain, $this->getBaseUrlForMultidomain());
    }

    public function get($loc)
    {
        return $this->repository->findOneByLoc($loc);
    }

    public function pages()
    {
        return $this->repository->pages($this->limit, $this->isMultidomain, $this->getBaseUrlForMultidomain());
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

    protected function getBaseUrlForMultidomain()
    {
        if (!is_string($this->baseUrl)) {
            $this->baseUrl = '';
            if ($this->isMultidomain) {
                $request = $this->requestStack->getCurrentRequest();
                if ($request) {
                    $this->baseUrl = $request->getScheme() . '://' . $request->getHost();
                }
            }
        }

        return $this->baseUrl;
    }
}
