<?php
$flairTestUtilitiesPath = dirname(__FILE__) . DIRECTORY_SEPARATOR;
$flairTestUtilitiesPath .= 'utilities' . DIRECTORY_SEPARATOR;

require $flairTestUtilitiesPath . 'AutoLoader.php';
$flairTestAutoLoader = new Flair\PhpUnit\AutoLoader();

require $flairTestUtilitiesPath . 'TestCase.php';
