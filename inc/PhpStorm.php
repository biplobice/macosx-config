<?php
/**
 * Created by PhpStorm.
 * User: biplob
 * Date: 10/12/17
 * Time: 12:22 PM
 */

class PhpStorm
{
    public $sxe;

    public function __construct()
    {
        $this->xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><project version="4"></project>');
    }

    public function createWebServerXML($sites) {
        foreach ($sites as $site) {
            $component = $this->xml->addChild('component');
            $component->addAttribute('name', 'WebServers');

            $option = $component->addChild('option');
            $option->addAttribute('name', 'servers');

            $webServer = $option->addChild('webServer');
            $webServer->addAttribute('id', $this->generateWebServerId());
            $webServer->addAttribute('name', $site->name);
            $webServer->addAttribute('url', $site->hostname);

            $fileTransfer = $webServer->addChild('fileTransfer');
            $fileTransfer->addAttribute('host', $site->hostname);
            $fileTransfer->addAttribute('port', $site->port);
            $fileTransfer->addAttribute('privateKey', $site->keyfile);
            $fileTransfer->addAttribute('accessType', 'SFTP');
            $fileTransfer->addAttribute('keyPair', "true");
            $fileTransfer->addAttribute('rootFolder', $site->rootPath);

            $advancedOptions = $fileTransfer->addChild('advancedOptions');
            $advancedOptions2 = $advancedOptions->addChild('advancedOptions');
            $advancedOptions2->addAttribute('dataProtectionLevel', 'Private');
            $xml_file = $this->xml->asXML( 'files/' . $site->name . '.xml');
        }
    }

    public function createDeploymentXML($site) {
        $component = $this->xml->addChild('component');
        $component->addAttribute('name', 'PublishConfigData');
        $component->addAttribute('serverName', $site->name);

//        $xml_file = $this->xml->asXML( 'files/' . $site->name . '.xml');
    }

    private function generateWebServerId() {
        return time();
    }

}