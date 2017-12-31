<?php
require_once 'inc/autoloader.php';

$file = 'sites.xml';
$xml = simplexml_load_file($file);
$sites = $xml->site;

// Create ssh config file
$sc = new SshConfig();
$sc->createConfigFile($sites);

// Create sequel pro config
$sp = new SequelPro();
$sp->createConfigFile($sites);