<?php
namespace Biplob;

use SimpleXMLElement;
use DOMDocument;

class SequelPro
{
    public $xml;

    public function createConfigFile($sites)
    {
        $this->xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><!DOCTYPE plist PUBLIC "-//Apple//DTD PLIST 1.0//EN" "http://www.apple.com/DTDs/PropertyList-1.0.dtd"><plist version="1.0"/>');
        $this->addHeader();
        $this->addLocalhost();
        foreach ($sites as $name => $site) {
            if (!isset($site['database']) || empty($site['database'])) {
                continue;
            }
            $this->addSite($site, $name);
        }
        $this->addFooter();
//        $this->xml->asXML('/Users/biplob/Library/Application Support/Sequel Pro/Data/Favorites.plist');

        //Format XML to save indented tree rather than one line
        $dom = new DOMDocument('1.0');
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;
        $dom->loadXML($this->xml->asXML());
        $filePath = $_SERVER['HOME'] . '/Library/Application Support/Sequel Pro/Data/Favorites.plist';
        if (file_exists($filePath)) {
            unlink($filePath);
        }
        $dom->save($filePath);
    }

    public function addHeader()
    {
        $dict = $this->xml->addChild('dict');
        $dict->addChild('key', 'Favorites Root');
        $dict = $dict->addChild('dict');
        $dict->addChild('key', 'Children');
        $this->array = $dict->addChild('array');
    }

    public function addLocalhost()
    {
        $dict = $this->xml->dict->dict->array->addChild('dict');

        $dict->addChild('key', 'colorIndex');
        $dict->addChild('integer', -1);

        $dict->addChild('key', 'database');
        $dict->addChild('string', '');

        $dict->addChild('key', 'host');
        $dict->addChild('string', '127.0.0.1');

        $dict->addChild('key', 'id');
        $dict->addChild('integer', -2490508938092353399);

        $dict->addChild('key', 'name');
        $dict->addChild('string', 'localhost');

        $dict->addChild('key', 'port');
        $dict->addChild('string', '');

        $dict->addChild('key', 'socket');
        $dict->addChild('string', '');

        $dict->addChild('key', 'sshHost');
        $dict->addChild('string', '');

        $dict->addChild('key', 'sshKeyLocation');
        $dict->addChild('string', '');

        $dict->addChild('key', 'sshKeyLocationEnabled');
        $dict->addChild('integer', 1);

        $dict->addChild('key', 'sshPort');
        $dict->addChild('string', '');

        $dict->addChild('key', 'sshUser');
        $dict->addChild('string', '');

        $dict->addChild('key', 'sslCACertFileLocation');
        $dict->addChild('string', '');

        $dict->addChild('key', 'sslCACertFileLocationEnabled');
        $dict->addChild('integer', 0);

        $dict->addChild('key', 'sslCertificateFileLocation');
        $dict->addChild('string', '');

        $dict->addChild('key', 'sslCertificateFileLocationEnabled');
        $dict->addChild('integer', 0);

        $dict->addChild('key', 'sslKeyFileLocation');
        $dict->addChild('string', '');

        $dict->addChild('key', 'sslKeyFileLocationEnabled');
        $dict->addChild('integer', 0);

        $dict->addChild('key', 'type');
        $dict->addChild('integer', 1);

        $dict->addChild('key', 'useSSL');
        $dict->addChild('integer', 0);

        $dict->addChild('key', 'user');
        $dict->addChild('string', 'root');
    }

    public function addSite($site, $name)
    {
        $dict = $this->xml->dict->dict->array->addChild('dict');

        $dict->addChild('key', 'colorIndex');
        $dict->addChild('integer', -1);

        $dict->addChild('key', 'database');
        $dict->addChild('string', array_get($site, 'database.name'));

        $dict->addChild('key', 'host');
        $dict->addChild('string', array_get($site, 'database.host'));

        $dict->addChild('key', 'id');
        $dict->addChild('integer', $this->get64BitNumber($name));

        $dict->addChild('key', 'name');
        $env =  array_get($site, 'env');
        if ($env == 'prod') {
            $name = $env . ' !!! ' . $name;
        }
        $dict->addChild('string', $name);

        $dict->addChild('key', 'port');
        $dict->addChild('string', array_get($site, 'database.port'));

        $dict->addChild('key', 'socket');
        $dict->addChild('string', '');

        $dict->addChild('key', 'sshHost');
        $dict->addChild('string', array_get($site, 'host'));

        $dict->addChild('key', 'sshKeyLocation');
        $dict->addChild('string', array_get($site, 'sshKey'));

        $dict->addChild('key', 'sshKeyLocationEnabled');
        $dict->addChild('integer', array_has($site, 'sshKey') ? 1 : 0);

        $dict->addChild('key', 'sshPort');
        $dict->addChild('string', array_get($site, 'port'));

        $dict->addChild('key', 'sshUser');
        $dict->addChild('string', array_get($site, 'user'));

        $dict->addChild('key', 'sslCACertFileLocation');
        $dict->addChild('string', '');

        $dict->addChild('key', 'sslCACertFileLocationEnabled');
        $dict->addChild('integer', 0);

        $dict->addChild('key', 'sslCertificateFileLocation');
        $dict->addChild('string', '');

        $dict->addChild('key', 'sslCertificateFileLocationEnabled');
        $dict->addChild('integer', 0);

        $dict->addChild('key', 'sslKeyFileLocation');
        $dict->addChild('string', '');

        $dict->addChild('key', 'sslKeyFileLocationEnabled');
        $dict->addChild('integer', 0);

        $dict->addChild('key', 'type');
        $dict->addChild('integer', 2);

        $dict->addChild('key', 'useSSL');
        $dict->addChild('integer', 0);

        $dict->addChild('key', 'user');
        $dict->addChild('string', array_get($site, 'database.user'));
    }

    public function addFooter()
    {
        $this->xml->dict->dict->addChild('key', 'IsExpanded');
        $this->xml->dict->dict->addChild('true', '');
        $this->xml->dict->dict->addChild('key', 'Name');
        $this->xml->dict->dict->addChild('string', 'FAVORITES');
    }

    public function get64BitNumber($str)
    {
        return gmp_strval(gmp_init(substr(md5($str), 0, 16), 16), 10);
    }
}