<?php
require_once __DIR__ . '/vendor/autoload.php';

use Console\DownloadCommand;
use Console\UploadCommand;
use Symfony\Component\Console\Application;

define( 'FS__API_SCOPE', 'developer' );

$app = new Application('Freemius', '1.0.0');
$app->add(new UploadCommand());
$app->add(new DownloadCommand());
$app -> run();
