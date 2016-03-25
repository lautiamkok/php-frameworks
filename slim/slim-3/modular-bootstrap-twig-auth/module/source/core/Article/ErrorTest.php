<?php
namespace Spectre\Article;

// PSR 7 standard.
use Slim\Http\Request;
use Slim\Http\Response;

class ErrorTest
{
    /**
     * [__construct description]
     * @param [type] $container [description]
     */
    public function __construct($container)
    {
        $this->container = $container;
    }

    /**
     * Fetch row.
     * @param  array  $options [description]
     * @return [type]          [description]
     */
    public function getError()
    {
        // Return the result.
        return 'Hello Error';
    }

    /**
     * [__invoke description]
     * @param  Request  $request  [description]
     * @param  Response $response [description]
     * @return [type]             [description]
     */
    public function __invoke(Request $request, Response $response)
    {
        // Return the result.
        return 'Hello Error';
        // Get the core & local database configurations.
        $databaseCore = require $this->container->settings['database']['core'];
        $databaseLocal = require $this->container->settings['database']['local'];

        // Merge the configurations.
        $databaseConfig = array_merge($databaseCore, $databaseLocal);

        // Instance of PdoAdapter.
        $PdoAdapter = new PdoAdapter($databaseConfig['dsn'], $databaseConfig['username'], $databaseConfig['password']);

        // Make connection.
        $PdoAdapter->connect();

        // Gateway & Mapper.
        $NotFoundGateway = new NotFoundGateway($PdoAdapter);
        $NotFoundMapper = new NotFoundMapper($NotFoundGateway);

        // Service.
        $NotFoundService = new NotFoundService($NotFoundMapper);

        // Get the article object.
        $NotFoundModel = $NotFoundService->getNotFound([
            "url" => '404 not found'
        ]);

        print_r($NotFoundModel);

        $container = $this->container;
        $response->getBody()->write('Not found!');
        return $response->withStatus(404);
    }
}
