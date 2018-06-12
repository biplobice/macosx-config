<?php
namespace Biplob;

use SimpleXMLElement;

class FileZilla
{
    public $xml;

    public function createXMLFile($sites)
    {
        $this->xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><FileZilla3 version="3.31.0" platform="mac"></FileZilla3>');
        $servers = $this->xml->addChild('Servers');

        foreach ($sites as $name => $site) {
            $server = $servers->addChild('Server');
            $server->addChild('Host', array_get($site, 'host'));
            $server->addChild('Port', array_get($site, 'port', 21));
            $server->addChild('Protocol', 0);
            $server->addChild('Type', 0);
            $server->addChild('User', array_get($site, 'user'));
            $server->addChild('Pass', array_get($site, 'pass'));
            $server->addChild('Logontype', 1);
            $server->addChild('TimezoneOffset', 0);
            $server->addChild('PasvMode', 'MODE_DEFAULT');
            $server->addChild('MaximumMultipleConnections', 0);
            $server->addChild('EncodingType', 'Auto');
            $server->addChild('BypassProxy', 0);
            $server->addChild('Name', $name);
            $server->addChild('Comments');
            $server->addChild('Colour', 0);
            $server->addChild('LocalDir');
            $server->addChild('RemoteDir');
            $server->addChild('SyncBrowsing', 0);
            $server->addChild('DirectoryComparison', 0);
        }

        $this->xml->asXML($_SERVER['HOME'] . '/.config/filezilla/sitemanager.xml');
    }
}