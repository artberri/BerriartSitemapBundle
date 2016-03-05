Populating the sitemap with existing urls
=========================================

You can populate the sitemap creating custom url providers and executing the
`berriart:sitemap:populate`. Foreach group of urls that you want to add to the
sitemap you have to create a url provider and create a service with it.

## Simple Url Provider

The UrlProvider class that you have to create implementing the UrlProviderInterface
interface and populate method.

``` php
// YourBrand/Bundle/YourBundle/Sitemap/ExampleUrlProvider.php

namespace YourBrand\Bundle\YourBundle\Sitemap;

use Symfony\Component\Routing\Router;
use Berriart\Bundle\SitemapBundle\Provider\UrlProviderInterface;
use Berriart\Bundle\SitemapBundle\Manager\Sitemap;
use Berriart\Bundle\SitemapBundle\Entity\Url;

class ExampleUrlProvider implements UrlProviderInterface {

    protected $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function populate(Sitemap $sitemap)
    {
        $exampleUrl = $this->router->generate('berriart_news_show');
        $url = new Url();
        $url->setLoc($exampleUrl);
        $url->setChangefreq(Url::CHANGEFREQ_DAILY);
        $url->setPriority('0.4');

        $sitemap->add($url);

        $sitemap->save();
    }
}
```

Configuring the dependency injection

``` yaml
# Resources/config/services.yml
parameters:
    your_bundle.sitemap.provider.sample.class: YourBrand\Bundle\YourBundle\Sitemap\ExampleUrlProvider

services:
    your_bundle.sitemap.provider.sample:
        class: %your_bundle.sitemap.provider.sample.class%
        arguments: [@router]
        tags:
            -  { name: berriart_sitemap.provider }
```

## Repository Url Provider

``` php
namespace YourBrand\Bundle\YourBundle\Sitemap;

use Symfony\Component\Routing\Router;
use Berriart\Bundle\SitemapBundle\Provider\UrlProviderInterface;
use Berriart\Bundle\SitemapBundle\Manager\Sitemap;
use Berriart\Bundle\SitemapBundle\Entity\Url;
use YourBrand\Bundle\YourBundle\Entity\Article;
use YourBrand\Bundle\YourBundle\Repository\ArticleRepository;

class ArticleUrlProvider implements UrlProviderInterface {

    protected $articleRepository;
    protected $router;

    public function __construct(ArticleRepository $articleRepository, Router $router)
    {
        $this->articleRepository = $articleRepository;
        $this->router = $router;
    }

    public function populate(Sitemap $sitemap)
    {
        foreach ($this->articleRepository->findAll() as $article) {
            $articleUrl = $this->router->generate('article_show', array('slug' => $article->getSlug()));
            $url = new Url();
            $url->setLoc($articleUrl);
            if($article->getUpdatedAt()) {
                $url->setLastmod($article->getUpdatedAt());
            }
            else {
                $url->setLastmod($article->getCreatedAt());
            }
            $url->setChangefreq(Url::CHANGEFREQ_DAILY);
            $url->setPriority('0.4');

            $sitemap->add($url);
        }

        $sitemap->save();
    }
}
```

Register your provider and repository in DIC like this:

``` yaml
# Resources/config/services.yml
parameters:
    your_bundle.repository.article.class: YourBrand\Bundle\YourBundle\Repository\ArticleRepository
    your_bundle.entity.article.class: YourBrand\Bundle\YourBundle\Entity\Article
    your_bundle.sitemap.provider.article.class: YourBrand\Bundle\YourBundle\Sitemap\ArticleUrlProvider

services:
    your_bundle.repository.article:
        class: %your_bundle.repository.article.class%
        factory_service: doctrine.orm.entity_manager
        factory_method: getRepository
        arguments: [%your_bundle.entity.article.class%]
    your_bundle.sitemap.provider.article:
        class: %your_bundle.sitemap.provider.article.class%
        arguments: [@your_bundle.repository.article, @router]
        tags:
            -  { name: berriart_sitemap.provider }
```

**NOTE:** in the above examples, we use router to relative urls or paths. Upon
rendering, sitemap will figure out if the url is relative and will prefix it
with current base url. If you want your urls to belong to certain domain, that
might be different from the one the sitemap will be available at, make sure to
use absolute urls.

## Populate command

After providers are in place and registered, time to run the generation command:

    > php app/console berriart:sitemap:populate
