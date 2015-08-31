<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Nice\Application;
use Nice\DependencyInjection\ConfigurationProvider\FileConfigurationProvider;
use Nice\Extension\LogExtension;
use Nice\Extension\CacheExtension;
use Nice\Extension\DoctrineDbalExtension;
use Nice\Extension\DoctrineKeyValueExtension;
use Nice\Extension\SecurityExtension;
use Nice\Extension\SessionExtension;
use Nice\Router\RouteCollector;

require __DIR__.'/../vendor/autoload.php';

// Enable Symfony debug error handlers
Symfony\Component\Debug\Debug::enable();

$app = new Application('dev', true, false);
$app->setConfigurationProvider(new FileConfigurationProvider(__DIR__.'/../config.yml'));
$app->appendExtension(new SessionExtension());
$app->appendExtension(new CacheExtension());
$app->appendExtension(new DoctrineKeyValueExtension());
$app->appendExtension(new DoctrineDbalExtension());
$app->appendExtension(new LogExtension());
$app->appendExtension(new SecurityExtension());

\Doctrine\Common\Annotations\AnnotationRegistry::registerAutoloadNamespace('Doctrine\KeyValueStore', __DIR__.'/../vendor/doctrine/key-value-store/lib');

// Configure your routes
$app->set('routes', function (RouteCollector $r) {
    $r->map('/', 'home', function (Application $app) {
        $app->get('logger.default')->debug('This is a test');
        $url = $app->get('router.url_generator')->generate('hello', array('name' => 'Tyler'));

        return new Response('Hello, world. <a href="'.$url.'">Hello, Tyler.</a>');
    });

    $r->map('/last-visit', null, function (Application $app, Request $request) {
        $session = $request->getSession();

        $lastVisit = $session->get('last-visited', 'Never');
        $session->set('last-visited', date('Y-m-d'));

        return new Response('You last visited on: '.$lastVisit);
    });

    $r->map('/login', null, function (Application $app, Request $request) {
        return new Response('<form action="login_check" method="post"><input name="user" /><button>Save</button></form>');
    });

    $r->map('/hello/{name}', 'hello', function (Application $app, Request $request, $name) {
        $cache = $app->get('cache.default');
        $cache->save('last-hello', $name);

        return new Response('Hello, '.$name.'!');
    });

    $r->map('/last-hello', null, function (Application $app) {
        $cache = $app->get('cache.default');
        $name = $cache->fetch('last-hello');

        if (!$name) {
            return new Response('I have not said "Hello" to anyone :(');
        }

        return new Response('Last said hello to: '.$name);
    });

    $r->map('/messages', null, function (Application $app, Request $request) {
        $conn = $app->get('doctrine.dbal.database_connection');
        $results = $conn->executeQuery("SELECT * FROM messages")->fetchAll();

        return new \Symfony\Component\HttpFoundation\JsonResponse($results);
    });

    $r->map('/make-person/{name}/{age}', null, function (Application $app, $name, $age) {
        $em = $app->get('doctrine.key_value.entity_manager');
        $person = new \Example\Person($name, $age);
        $em->persist($person);
        $em->flush();

        return new Response('Person added!');
    });

    $r->map('/person/{name}', null, function (Application $app, $name) {
        $em = $app->get('doctrine.key_value.entity_manager');

        $person = $em->find('Example\Person', $name);
        if (!$person) {
            return new Response('Unable to find '.$name);
        }

        return new Response($name.' is '.$person->getAge().' years old!');
    });
});

$app->set('security.authenticator', function (Request $request) {
    return $request->get('user') === 'tom';
});

// Run the application
$app->run();
