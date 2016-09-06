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

1. Install BerriartSitemapBundle
2. Enable the Bundle
3. Configure the BerriartSitemapBundle
4. Import BerriartSitemapBundle routing
5. Update your database schema

### Step 1: Install BerriartSitemapBundle

```
composer require berriart/sitemap-bundle
```

### Step 2: Enable the bundle

Enable the bundle in the kernel:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Berriart\Bundle\SitemapBundle\BerriartSitemapBundle(),
        // ...
    );
}
```

### Step 3: Configure the BerriartSitemapBundle

The next step is the basic configuration of the bundle. Add the following lines to
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
adding the alias configuration.

The default number of urls (locs) per sitemap page is 50000, you can change it from
the bundle configuration too.

The default behaviour is to show every URL in the sitemap. You can add multidomain
support, if you do so, only the URLs that start with the domain of the request will be shown. With the
multidomain support enabled you are required to add the full URLs, including protocol,
domain, path...

``` yaml
# app/config/config.yml
berriart_sitemap:
    base_url: http://example.org
    alias: your_own_sitemap_alias
    url_limit: 50000
    multidomain: false
```

**Note:**

> The `base_url` will be added to the relative urls of the sitemap if multidomain is off.

**Warning:**

> You need either to use the `auto_mapping` option of the corresponding bundle
> (done by default for DoctrineBundle in the standard distribution) or to
> activate the mapping for BerriartSitemapBundle otherwise the mapping
> will be ignored.

### Step 4: Import BerriartSitemapBundle routing file

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

### Step 5: Update your database schema

Now that the bundle is configured, the last thing you need to do is update your
database schema because the bundle adds two entities and two new tables.

Execute the following command

``` bash
$ php bin/console doctrine:schema:update --force
```

Or if you prefer to execute the SQL manually

``` bash
$ php bin/console doctrine:schema:update --dump-sql
```

**Note:**

> We are supposing you are using Symfony 3, if you are still using version 2 replace
> `bin/console` with `app/console`.

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
