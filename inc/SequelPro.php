<?php

class SequelPro
{
    public $xml;

    public function createConfigFile($sites)
    {
        $this->xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><!DOCTYPE plist PUBLIC "-//Apple//DTD PLIST 1.0//EN" "http://www.apple.com/DTDs/PropertyList-1.0.dtd"><plist version="1.0"/>');
        $this->addHeader();
        foreach ($sites as $site) {
            $this->addSite($site);
        }
        $this->addFooter();
//        $this->xml->asXML('/Users/biplob/Library/Application Support/Sequel Pro/Data/Favorites.plist');

        //Format XML to save indented tree rather than one line
        $dom = new DOMDocument('1.0');
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;
        $dom->loadXML($this->xml->asXML());
        $filePath = '/Users/biplob/Library/Application Support/Sequel Pro/Data/Favorites.plist';
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

    public function addSite($site)
    {
        $dict = $this->xml->dict->dict->array->addChild('dict');

        $dict->addChild('key', 'colorIndex');
        $dict->addChild('integer', -1);

        $dict->addChild('key', 'database');
        $dict->addChild('string', '');

        $dict->addChild('key', 'host');
        $dict->addChild('string', $site->database->hostname);

        $dict->addChild('key', 'id');
        $dict->addChild('integer', -2490508938092353399);

        $dict->addChild('key', 'name');
        $dict->addChild('string', $site->name);

        $dict->addChild('key', 'port');
        $dict->addChild('string', $site->database->port);

        $dict->addChild('key', 'socket');
        $dict->addChild('string', '');

        $dict->addChild('key', 'sshHost');
        $dict->addChild('string', $site->hostname);

        $dict->addChild('key', 'sshKeyLocation');
        $dict->addChild('string', $site->keyfile);

        $dict->addChild('key', 'sshKeyLocationEnabled');
        $dict->addChild('integer', 1);

        $dict->addChild('key', 'sshPort');
        $dict->addChild('string', $site->port);

        $dict->addChild('key', 'sshUser');
        $dict->addChild('string', $site->username);

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
        $dict->addChild('string', $site->database->username);
    }

    public function addFooter()
    {
        $this->xml->dict->dict->addChild('key', 'IsExpanded');
        $this->xml->dict->dict->addChild('true', '');
        $this->xml->dict->dict->addChild('key', 'Name');
        $this->xml->dict->dict->addChild('string', 'FAVORITES');
    }
}