<?php
$flairTestUtilitiesPath = dirname(__FILE__) . DIRECTORY_SEPARATOR;
$flairTestUtilitiesPath .= 'utilities' . DIRECTORY_SEPARATOR;

require $flairTestUtilitiesPath . 'DataTypeProvider.php';
require $flairTestUtilitiesPath . 'AutoLoader.php';

$flairTestAutoLoader = new Flair\PhpUnit\AutoLoader();