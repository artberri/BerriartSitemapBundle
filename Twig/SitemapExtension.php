<?php

namespace Berriart\Bundle\SitemapBundle\Twig;

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

use InvalidArgumentException;

class SitemapExtension extends \Twig_Extension
{
    private $baseUrl;
    private $scheme;
    private $validScheme = array('http', 'https');

    public function __construct($baseUrl)
    {
        $this->baseUrl = trim($baseUrl, '/');
        $this->scheme = preg_replace('#^(\w+)://.+$#', '$1', $baseUrl);

        if(!in_array($this->scheme, $this->validScheme)) {
            throw new InvalidArgumentException(sprintf('Base url "%s" does not have a valid scheme', $baseUrl));
        }
    }

    public function getFilters()
    {
        return array(
            'berriart_sitemap_absolutize' => new \Twig_Filter_Method($this, 'getAbsoluteUrl'),
        );
    }

    public function getAbsoluteUrl($path)
    {
        if (0 !== strpos($path, '/')) {
            return $path;
        }
        if ('//' === substr($path, 0, 2)) {
            return $this->scheme.':'.$path;
        }
        return $this->baseUrl.$path;
    }

    private function getKnownSchemes()
    {
        return array('http', 'https');
    }

    public function getName()
    {
        return 'berriart_sitemap';
    }
}
