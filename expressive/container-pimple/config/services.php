<?php
use Interop\Container\Pimple\PimpleInterop as Pimple;
use Zend\Expressive\Container;
use Zend\Expressive\Plates\PlatesRenderer;
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
$container[TemplateRendererInterface::class] = function ($container) {
    return new PlatesRenderer();
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
