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
use Symfony\Component\Console\Input\InputOption;
use Doctrine\ORM\Query\ResultSetMapping;

class PopulateCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('berriart:sitemap:populate')
            ->setDescription('Populate url database, using url providers.')
            ->setDefinition(array(
                    new InputOption('clear-sitemap', null, InputOption::VALUE_NONE, 'Clear sitemap first')
            )
        );
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $sitemap = $this->getContainer()->get('berriart_sitemap');

        if (true === $input->getOption('clear-sitemap')) {
            $this->clearSitemap();
            $output->write('<info>Sitemap cleared!</info>', true);
        }

        $this->getContainer()->get('berriart_sitemap.provider.chain')->populate($sitemap);

        $output->write('<info>Sitemap was sucessfully populated!</info>', true);
    }

    private function clearSitemap()
    {
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        $platform = $em->getConnection()->getDatabasePlatform();
        $tables = array(
                $em->getClassMetadata($this->getContainer()->getParameter('berriart_sitemap.entity.url.class'))->getTableName(),
                $em->getClassMetadata($this->getContainer()->getParameter('berriart_sitemap.entity.image_url.class'))->getTableName()
        );

        $em->getConnection()->executeUpdate("SET foreign_key_checks = 0;");

        foreach ($tables as $table) {
            $em->getConnection()->executeUpdate($platform->getTruncateTableSQL($table, true));
        }

        $em->getConnection()->executeUpdate("SET foreign_key_checks = 1;");
    }
}
