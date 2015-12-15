<?php
// Routes

// $app->get('/[{name}]', function ($request, $response, $args) {
//     // Sample log message
//     $this->logger->info("Slim-Skeleton '/' route");

//     // Render index view
//     return $this->renderer->render($response, 'index.phtml', $args);
// });

// Get the core & local modules configurations.
$modulesCore = require $app->getContainer()->get('settings')['modules']['core'];
$modulesLocal = require $app->getContainer()->get('settings')['modules']['local'];

// Merge the configurations.
$modules = array_merge($modulesCore, $modulesLocal);

// Loop the merge array and include the classes in them.
foreach($modules as $module) {
    // List all the php files inside the folder.
    $files[] = APPLICATION_ROOT . 'module/config/' . $module['directories']['route'] . 'route.php';
}

// Loop and include the files.
foreach($files as $file) {
    require $file;
}
