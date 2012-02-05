BerriartSitemapBundle Documentation
===================================

## Requirements

This BerriartSitemapBundle requires DoctrineBundle and a database conexion enabled, 
it will create two tables (berriart_sitemap_url and berriart_sitemap_url_image)

## Credits

This Bundle is fully inspired by the [AvalancheSitemapBundle](https://github.com/avalanche123/AvalancheSitemapBundle), but instead of using 
DoctrineMongoDBBundle it uses DoctrineBundle so you can use it, for example, with a 
MySQL database.

## Installation

Follow these steps to complete the installation:

1. Download BerriartSitemapBundle
2. Configure the Autoloader
3. Enable the Bundle
4. Configure the BerriartSitemapBundle
5. Import BerriartSitemapBundle routing
6. Update your database schema

### Step 1: Download BerriartSitemapBundle

Ultimately, the BerriartSitemapBundle files should be downloaded to the
`vendor/bundles/Berriart/Bundle/SitemapBundle` directory.

This can be done in several ways, depending on your preference. The first
method is the standard Symfony2 method.

**Using the vendors script**

Add the following lines in your `deps` file:

```
[BerriartSitemapBundle]
    git=http://github.com/artberri/BerriartSitemapBundle.git
    target=bundles/Berriart/Bundle/SitemapBundle
```

Now, run the vendors script to download the bundle:

``` bash
$ php bin/vendors install
```

**Using submodules**

If you prefer instead to use git submodules, then run the following:

``` bash
$ git submodule add http://github.com/artberri/BerriartSitemapBundle.git vendor/bundles/Berriart/Bundle/SitemapBundle
$ git submodule update --init
```

### Step 2: Configure the Autoloader

Add the `Berriart` namespace to your autoloader:

``` php
<?php
// app/autoload.php

$loader->registerNamespaces(array(
    // ...
    'Berriart' => __DIR__.'/../vendor/bundles',
));
```

### Step 3: Enable the bundle

Finally, enable the bundle in the kernel:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Berriart\Bundle\SitemapBundle\BerriartSitemapBundle(),
    );
}
```

### Step 4: Configure the BerriartSitemapBundle

The next step is to configure the bundle. Add the following configuration to 
your `config.yml` based on your project's url.

``` yaml
# app/config/config.yml
berriart_sitemap:
    base_url: http://example.org # it will be used if you store relative urls
```

Or if you prefer XML:

``` xml
# app/config/config.xml
<!-- app/config/config.xml -->

<berriart_sitemap:config
    base-url="orm"
/>
```

The default alias of the bundle's sitemap service is `sitemap`, you can change it
adding the alias configuration:

``` yaml
# app/config/config.yml
berriart_sitemap:
    base_url: http://example.org 
    alias: your_own_sitemap_alias
```

**Note:**

> The `base_url` will be added to the relative urls added to the sitemap.

**Warning:**

> You need either to use the `auto_mapping` option of the corresponding bundle
> (done by default for DoctrineBundle in the standard distribution) or to 
> activate the mapping for BerriartSitemapBundle otherwise the mapping 
> will be ignored.

### Step 5: Import BerriartSitemapBundle routing file

By importing the routing file you will activate the `/sitemapindex.xml` and
`/sitemap.xml` routes. If you prefer others, create your own routings.

In YAML:

``` yaml
# app/config/routing.yml
berriart_sitemap:
    resource: "@BerriartSitemapBundle/Resources/config/routing.yml"
    prefix:   /
```

Or if you prefer XML:

``` xml
<!-- app/config/routing.xml -->
<import resource="@BerriartSitemapBundle/Resources/config/routing.yml"/>
```

### Step 6: Update your database schema

Now that the bundle is configured, the last thing you need to do is update your
database schema because the bundle adds two entities and two new tables.

Execute the following command

``` bash
$ php app/console doctrine:schema:update --force
```

Or if you prefer to execute the SQL manually 

``` bash
$ php app/console doctrine:schema:update --dump-sql
```

### Next Steps

Now that you have completed the basic installation and configuration of the
BerriartSitemapBundle, you are ready to learn how to use it.

The following documents are available:

- [Adding/Editing/Removing urls from sitemap](manage_sitemap.md)
- [Populating the sitemap with existing urls](populating_sitemap.md)

## Future features

We are planning to add this features, if you have any better idea suggest it to us.

- Writing the sitemap files to disk and gzip them

Remember, Code Is Poetry
