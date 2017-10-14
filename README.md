MvErrorLogBundle
============

Bundle for Symfony2 >=2.8 and Symfony 3 that log app errors in db. (Symfony <= 2.7, see 1.x)
This doesn't log HTTP exceptions and Access denied exceptions. This was made only for bug tracking.
You will have trace and same precisions than dev mode in your log.

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/022bd576-8207-4ab8-93c1-f101393dabf7/small.png)](https://insight.sensiolabs.com/projects/022bd576-8207-4ab8-93c1-f101393dabf7)

[![Total Downloads](https://poser.pugx.org/mv/error-log-bundle/d/total.png)](https://packagist.org/packages/mv/error-log-bundle)

[![Latest Stable Version](https://poser.pugx.org/mv/error-log-bundle/version.png)](https://packagist.org/packages/mv/error-log-bundle)

INSTALLATION with COMPOSER
--------------------------

    php composer.phar require mv/error-log-bundle:"2.0"

###1)  Add to your AppKernel.php

    new Mv\ErrorLogBundle\MvErrorLogBundle(),

###2)  Add to config.yml

    imports:
        - { resource: "@MvErrorLogBundle/Resources/config/config.yml" }

**Be carrefull, may be you have already the "imports" key**

###3)  Update Database

ex:

    app/console doctrine:schema:update

or to have dump sql:

    app/console doctrine:schema:update --dump-sql

###4)  Ready to log app errors

Your app errors are logged in table mv\_error\_log

Enjoy...

To be continued
