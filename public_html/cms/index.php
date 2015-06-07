<?php
/* Set internal character encoding to UTF-8 */
mb_internal_encoding("UTF-8");

use Symfony\Component\Debug\Debug;

require_once __DIR__ . "/../../vendor/autoload.php";
Debug::enable('E_ALL');
$app = require __DIR__ . "/../../src/app.cms.php";
$app["debug"] = true;
$app->run();