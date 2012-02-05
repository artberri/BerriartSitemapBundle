<?php

namespace Berriart\Bundle\SitemapBundle\Command;

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

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Avalanche\Bundle\SitemapBundle\Sitemap\Provider;

class PopulateCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('berriart:sitemap:populate')
            ->setDescription('Populate url database, using url providers.');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $sitemap = $this->getContainer()->get('berriart_sitemap');

        $this->getContainer()->get('berriart_sitemap.provider.chain')->populate($sitemap);

        $output->write('<info>Sitemap was sucessfully populated!</info>', true);
    }
}