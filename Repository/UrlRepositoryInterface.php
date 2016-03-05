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

use Berriart\Bundle\SitemapBundle\Entity\Url;

interface UrlRepositoryInterface
{
    /**
     * URL limit by sitemap page
     */
    const LIMIT = 50000;

    function findOneByLoc($loc);
    function findAllOnPage($page, $limit = self::LIMIT);
    function add(Url $url);
    function remove(Url $url);
    function pages($limit = self::LIMIT);
    function flush();
}
