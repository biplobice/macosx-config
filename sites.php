<?php
require_once 'inc/autoloader.php';

$file = 'sites.xml';
$xml = simplexml_load_file($file);
$sites = $xml->site;

// Create ssh config file
$sc = new SshConfig();
$sc->createConfigFile($sites);

// Create Sequel Pro files
$sp = new SequelPro();
$sp->createConfigFile($sites);

// Create PhpStorm files
$phpStorm = new PhpStorm();
$phpStorm->createWebServerXML($sites);