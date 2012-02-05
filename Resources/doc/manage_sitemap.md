Adding/Editing/Removing urls from sitemap
=========================================

You can use the `sitemap` service from the controller, a command, like any other
service:

``` php
// YourBrand/Bundle/YourBundle/Controller/ExampleController.php
<?php
    // ...
    public function exampleAction()
    {
        // ...
        $sitemap = $this->get('sitemap');
        // ...
    }
```

``` php
// YourBrand/Bundle/YourBundle/Command/ExampleCommand.php
<?php
    // ...
    public function execute(InputInterface $input, OutputInterface $output)
    {
        // ...
        $sitemap = $this->getContainer()->get('sitemap');
        // ...
    }
```

## Adding/Editing/Removing urls from sitemap

``` php
// YourBrand/Bundle/YourBundle/Controller/ExampleController.php
<?php
use Berriart\Bundle\BerriartSitemap\Entity\Url;
use Berriart\Bundle\BerriartSitemap\Entity\ImageUrl;

    // ...
    public function exampleAction()
    {
        $sitemap = $this->get('sitemap');

        // ...
        
        // Adding a url with complete data to the sitemap (only loc is required)
        // Create url 
        $url = new Url();
        $url->setLoc('/relative/url/sample');
        $url->setLastmod(new \DateTime());
        $url->setChangefreq(Url::CHANGEFREQ_DAILY);
        $url->setPriority('0.4');
        // Create image url and add it to the url
        $image = new ImageUrl();
        $image->setLoc($imageLoc);
        $image->setCaption($caption);
        $image->setGeoLocation($geoLocation);
        $image->setTitle($title);
        $image->setLicense($license);
        $image->setUrl($url);
        // Add to the sitemap
        // (to complete the insert to db you must call save method, same on update or delete)
        $sitemap->add($url);

        // Other adding url sample
        $sitemap->add(new Url('http://example.com'));

        // Updating a url
        $url3 = $sitemap->get('/sample/url/1');
        $url3->setLastmod(new \DateTime());

        // Removing a url
        $sitemap->remove($url4);

        // After doing any changes you have to save them
        $sitemap->save();
    }
```





