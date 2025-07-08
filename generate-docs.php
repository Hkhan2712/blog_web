<?php
require_once __DIR__ . '/vendor/autoload.php'; 

use OpenApi\Generator;

$openapi = Generator::scan([__DIR__ . '/controllers']);
file_put_contents(__DIR__ . '/swagger.json', $openapi->toJson());

echo "Swagger file generated successfully.";