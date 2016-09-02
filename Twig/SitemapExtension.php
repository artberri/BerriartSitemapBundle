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
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Request;

class SitemapExtension extends \Twig_Extension
{
    protected $requestStack;
    protected $baseUrl;
    protected $scheme;
    protected $isMultidomain;

    public function __construct(RequestStack $requestStack, $baseUrl, $multidomain)
    {
        $this->requestStack = $requestStack;
        $this->baseUrl = trim($baseUrl, '/');
        $this->isMultidomain = $multidomain;
        $this->scheme = preg_replace('#^(\w+)://.+$#', '$1', $baseUrl);

        if (!in_array($this->scheme, $this->getKnownSchemes())) {
            throw new InvalidArgumentException(sprintf('Base url "%s" does not have a valid scheme', $baseUrl));
        }
    }

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('berriart_sitemap_absolutize', array($this, 'getAbsoluteUrl')),
        );
    }

    public function getAbsoluteUrl($path)
    {
        if (0 !== strpos($path, '/')) {
            return $path;
        }

        if ('//' === substr($path, 0, 2)) {
            return $this->getScheme() . ':' . $path;
        }

        return $this->getBaseUrl() . $path;
    }

    public function getName()
    {
        return 'berriart_sitemap';
    }

    protected function getKnownSchemes()
    {
        return array('http', 'https');
    }

    protected function getBaseUrl()
    {
        $baseUrl = $this->baseUrl;

        if ($this->isMultidomain) {
            $request = $this->requestStack->getCurrentRequest();
            $baseUrl = $request->getScheme() . '://' . $request->getHost();
        }

        return $baseUrl;
    }

    protected function getScheme()
    {
        $scheme = $this->scheme;

        if ($this->isMultidomain) {
            $request = $this->requestStack->getCurrentRequest();
            $scheme = $request->getScheme();
        }

        return $scheme;
    }
}
