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
        $this->xml->asXML('/Users/YOUR_USER_ID/Library/Application Support/Sequel Pro/Data/Favorites.plist');
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
        $dict->addChild('integer', $site->database->hostname);

        $dict->addChild('key', 'id');
        $dict->addChild('string', -2490508938092353399);

        $dict->addChild('key', 'name');
        $dict->addChild('integer', $site->name);

        $dict->addChild('key', 'port');
        $dict->addChild('string', $site->database->port);

        $dict->addChild('key', 'socket');
        $dict->addChild('integer', '');

        $dict->addChild('key', 'sshHost');
        $dict->addChild('string', $site->hostname);

        $dict->addChild('key', 'sshKeyLocation');
        $dict->addChild('integer', $site->keyfile);

        $dict->addChild('key', 'sshKeyLocationEnabled');
        $dict->addChild('string', 1);

        $dict->addChild('key', 'sshPort');
        $dict->addChild('integer', $site->port);

        $dict->addChild('key', 'sshUser');
        $dict->addChild('string', $site->username);

        $dict->addChild('key', 'sslCACertFileLocation');
        $dict->addChild('integer', '');

        $dict->addChild('key', 'sslCACertFileLocationEnabled');
        $dict->addChild('string', 0);

        $dict->addChild('key', 'sslCertificateFileLocation');
        $dict->addChild('integer', '');

        $dict->addChild('key', 'sslCertificateFileLocationEnabled');
        $dict->addChild('string', 0);

        $dict->addChild('key', 'sslKeyFileLocation');
        $dict->addChild('integer', '');

        $dict->addChild('key', 'sslKeyFileLocationEnabled');
        $dict->addChild('string', 0);

        $dict->addChild('key', 'type');
        $dict->addChild('integer', 2);

        $dict->addChild('key', 'useSSL');
        $dict->addChild('string', 0);

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