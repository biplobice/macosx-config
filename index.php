<?php
require_once 'vendor/autoload.php';

use Symfony\Component\Yaml\Yaml;
use Biplob\SshConfig;
use Biplob\SequelPro;
use Biplob\FileZilla;
use Biplob\PhpStorm;

$sites = Yaml::parseFile('sites.yaml');

// Create ssh config file
$sc = new SshConfig();
$sc->createConfigFile($sites);

// Create sequel pro config
$sp = new SequelPro();
$sp->createConfigFile($sites);

// Create PhpStorm files
$phpStorm = new PhpStorm();
$phpStorm->createGlobalWebServersXML($sites);
$phpStorm->createWebServerXML($sites);
$phpStorm->createDataSources($sites);

$fileZilla = new FileZilla();
$fileZilla->createXMLFile($sites);

echo 'Files generated successfully' . PHP_EOL;