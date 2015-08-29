# SYMFONY WEV DEVELOPMENT (SYMFONY 2)

## Installation (Windows)

1. In CMD, type `php -r "readfile('http://symfony.com/installer');" > symfony`

2. And `php symfony`

3. And `php symfony new my_project`

## Configuration

1. Go to `http://localhost/projects/symfony/web/config.php`

4. And also download,

    `php app/console assets:install web`

5. Add in `php.ini`,

    `xdebug.max_nesting_level = 250`

6. Click **Configure your Symfony Application online** and follow through the instructions on screen to finish up the config process.

## Creating Pages in Symfony

1. Before you begin: Create the Bundle

    A bundle is nothing more than a directory that houses everything related to a specific feature, including PHP classes, configuration, and even stylesheets and JavaScript files. (from http://symfony.com/doc/master/book/page_creation.html)

    A Bundle is a directory containing a set of files (PHP files, stylesheets, JavaScripts, images, ...) that implement a single feature (a blog, a forum, etc). In Symfony, (almost) everything lives inside a bundle. (from http://symfony.com/doc/master/glossary.html#term-bundle)

    Create your own bundle,

    `php app/console generate:bundle`

2. Provide a namespace,

    `Bunlde Namespace: Sym/Bundle/CrudeBundle`

3. Access your bundle, http://localhost/projects/symfony/web/app_dev.php/hello/World

## Custom exceptions,

go to,

    `app/Resources/`

create,

    ```
    TwigBundle/views/Exception/exception.html.twig
    TwigBundle/views/layout.html.twig
    ```

clean the cache,

    `php app/console cache:clear`

The controller example,

    ```
    class DefaultController extends Controller
    {
        public function indexAction($name)
        {
           throw $this->createNotFoundException('Sorry, Not found!');
        }
    }

    ```

# References:

http://www.kevwebdev.com/blog/installing-php-5-dot-4-on-windows-7-for-developing-with-symfony2.html

http://stackoverflow.com/questions/9549172/why-is-symfony2-not-copying-my-bundle-over

## Videos:

https://www.youtube.com/watch?v=z14t0N4ZPy0

https://www.youtube.com/watch?v=PONJajuH8P4

https://www.youtube.com/playlist?list=PLUpnKy5Si8zCfBpdy3ZLUsUvk3cNAIrCs

https://www.youtube.com/watch?v=L9m3hgO70-M (custom exception)