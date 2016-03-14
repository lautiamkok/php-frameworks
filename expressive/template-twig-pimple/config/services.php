<?php
use Interop\Container\Pimple\PimpleInterop as Pimple;
use Zend\Expressive\Container;
use Zend\Expressive\Twig\TwigRenderer;
use Zend\Expressive\Router;
use Zend\Expressive\Template\TemplateRendererInterface;

$container = new Pimple();

// Application and configuration
$container['config'] = include 'config/config.php';
$container['Zend\Expressive\Application'] = new Container\ApplicationFactory;

// Routing
// In most cases, you can instantiate the router you want to use without using a
// factory:
// $container['Zend\Expressive\Router\RouterInterface'] = function ($container) {
//     return new Router\Aura();
// };

// Templating
// In most cases, you can instantiate the template renderer you want to use
// without using a factory:
// $container[TemplateRendererInterface::class] = function ($container) {
//     return new PlatesRenderer();
// };
$container['TwigRenderer'] = function ($container) {
    // Create the engine instance:
    // $loader = new Twig_Loader_Array(include 'config/templates.php');
    $loader = new Twig_Loader_Filesystem(include 'config/templates.php');
    $twig = new Twig_Environment($loader);

    // // Configure it:
    // // $twig->addExtension(new CustomExtension());
    // // $twig->loadExtension(new CustomExtension();

    // Inject:
    return new TwigRenderer($twig);
};

// These next two can be added in any environment; they won't be used unless
// you add the WhoopsErrorHandler as the FinalHandler implementation:
$container['Zend\Expressive\Whoops'] = new Container\WhoopsFactory();
$container['Zend\Expressive\WhoopsPageHandler'] = new Container\WhoopsPageHandlerFactory();

// Error Handling
// If in development:
$container['Zend\Expressive\FinalHandler'] = new Container\WhoopsErrorHandlerFactory();

// If in production:
$container['Zend\Expressive\FinalHandler'] = new Container\TemplatedErrorHandlerFactory();

return $container;
