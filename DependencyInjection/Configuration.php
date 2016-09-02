<?php

namespace Berriart\Bundle\SitemapBundle\DependencyInjection;

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

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('berriart_sitemap');

        $rootNode
            ->children()
                ->scalarNode('base_url')->defaultValue(null)->end()
                ->scalarNode('alias')->defaultValue('sitemap')->end()
                ->scalarNode('url_limit')->defaultValue(50000)->end()
                ->scalarNode('multidomain')->defaultValue(false)->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
