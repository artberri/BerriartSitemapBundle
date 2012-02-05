<?php

namespace Berriart\Bundle\SitemapBundle\Controller;

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

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Berriart\Bundle\SitemapBundle\Manager\Sitemap;

class SitemapController
{ 
    private $sitemap;
    private $request;
    private $templating;

    public function __construct(Sitemap $sitemap, EngineInterface $templating, Request $request) //, EngineInterface $templating)
    {
        $this->sitemap = $sitemap;
        $this->request = $request;
        $this->templating = $templating;
    }
    
    public function getRequest()
    {
        return $this->request;
    }
    
    public function sitemap()
    {
        $page = $this->getRequest()->get('page', 1);

        $this->sitemap->setPage($page);

        return $this->templating->renderResponse('BerriartSitemapBundle:Sitemap:sitemap.xml.twig', array(
            'sitemap' => $this->sitemap
        ));
    }
    
    public function sitemapIndex()
    {
        return $this->templating->renderResponse('BerriartSitemapBundle:Sitemap:sitemapindex.xml.twig', array(
            'pages' => $this->sitemap->pages(),
        ));
    }
}
