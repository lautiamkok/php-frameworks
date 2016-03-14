<?php

$response->getBody()->write('Hello, ' . $name);
return $response->withHeader('Content-type', 'application/json');
