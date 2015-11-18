<?php

// Adapter.
use Barium\Adapter\PdoAdapter;

// Get the core & local database configurations.
$settings = $this->container->get('settings');
$databaseCore = require $settings['database']['core'];
$databaseLocal = require $settings['database']['local'];

// Merge the configurations.
$databaseConfig = array_merge($databaseCore, $databaseLocal);

// Instance of PdoAdapter.
$PdoAdapter = new PdoAdapter($databaseConfig['dsn'], $databaseConfig['username'], $databaseConfig['password']);

// Make connection.
$PdoAdapter->connect();

// Get the page not found content from the db.

// Get the view from the container which is Twig.
$twig = $this->container->get('view');

// From that get the Twig Loader instance (file loader in this case).
$loader = $twig->getLoader();

// Load the template through the Twig service in the DIC.
$template = $twig->loadTemplate('PageNotFound/index.html');

// Render the template using a simple content variable.
$response->write($template->render([]));

return $response->withStatus(404);
