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


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SitemapController extends Controller
{
    public function sitemapAction(Request $request)
    {
        $page = $request->get('page', 1);
        $sitemap = $this->get('berriart_sitemap');

        $sitemap->setPage($page);

        return $this->render('BerriartSitemapBundle:Sitemap:sitemap.xml.twig', array(
            'sitemap' => $sitemap
        ));
    }

    public function sitemapIndexAction()
    {
        $sitemap = $this->get('berriart_sitemap');

        return $this->render('BerriartSitemapBundle:Sitemap:sitemapindex.xml.twig', array(
            'pages' => $sitemap->pages(),
        ));
    }
}
