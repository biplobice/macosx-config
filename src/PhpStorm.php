<?php
/**
 * Created by PhpStorm.
 * User: biplob
 * Date: 10/12/17
 * Time: 12:22 PM
 */
namespace Biplob;

use SimpleXMLElement;

class PhpStorm
{
    public $xml;

    public function createGlobalWebServersXML($sites) 
    {
        $this->xml = new SimpleXMLElement('<application></application>');
        $component = $this->xml->addChild('component');
        $component->addAttribute('name', 'WebServers');
        
        $option = $component->addChild('option');
        $option->addAttribute('name', 'servers');        

        foreach ($sites as $name => $site) {
            $webServer = $this->xml->component->option->addChild('webServer');
            $webServer->addAttribute('id', $this->generateWebServerId());
            $webServer->addAttribute('name', $name);
            $webServer->addAttribute('url', 'http://' . array_get($site, 'host'));

            $fileTransfer = $webServer->addChild('fileTransfer');
            $fileTransfer->addAttribute('host', array_get($site, 'host'));
            $fileTransfer->addAttribute('port', array_get($site, 'port', 22));
            $fileTransfer->addAttribute('privateKey', str_replace('~', '$USER_HOME$', array_get($site, 'sshKey')));
            $fileTransfer->addAttribute('accessType', 'SFTP');
            $fileTransfer->addAttribute('keyPair', "true");
            $fileTransfer->addAttribute('rootFolder', array_get($site, 'rootPath', '/'));

            $advancedOptions = $fileTransfer->addChild('advancedOptions');
            $advancedOptions2 = $advancedOptions->addChild('advancedOptions');
            $advancedOptions2->addAttribute('dataProtectionLevel', 'Private');

            $option = $fileTransfer->addChild('option');
            $option->addAttribute('name', 'port');
            $option->addAttribute('value', array_get($site, 'port', 22));            
        }

        $file = $_SERVER['HOME'] . '/Library/Preferences/PhpStorm2018.1/options/webServers.xml';
        $this->xml->asXML($file);
    }

    public function createWebServerXML($sites)
    {
        foreach ($sites as $name => $site) {

            $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><project version="4"></project>');
            $component = $xml->addChild('component');
            $component->addAttribute('name', 'WebServers');

            $option = $component->addChild('option');
            $option->addAttribute('name', 'servers');

            $webServer = $option->addChild('webServer');
            $webServer->addAttribute('id', $this->generateWebServerId());
            $webServer->addAttribute('name', $name);
            $webServer->addAttribute('url', 'http://' . array_get($site, 'host'));

            $fileTransfer = $webServer->addChild('fileTransfer');
            $fileTransfer->addAttribute('host', array_get($site, 'host'));
            $fileTransfer->addAttribute('port', array_get($site, 'port', 22));
            $fileTransfer->addAttribute('privateKey', str_replace('~', '$USER_HOME$', array_get($site, 'sshKey')));
            $fileTransfer->addAttribute('accessType', 'SFTP');
            $fileTransfer->addAttribute('keyPair', "true");
            $fileTransfer->addAttribute('rootFolder', array_get($site, 'rootPath', '/'));

            $advancedOptions = $fileTransfer->addChild('advancedOptions');
            $advancedOptions2 = $advancedOptions->addChild('advancedOptions');
            $advancedOptions2->addAttribute('dataProtectionLevel', 'Private');

            $option = $fileTransfer->addChild('option');
            $option->addAttribute('name', 'port');
            $option->addAttribute('value', array_get($site, 'port', 22));

            $dir = "/Users/biplob/Sites/{$name}/.idea";
            $file = $dir . '/webServers.xml';
            if (is_dir($dir) && !file_exists($file)) {
                $xml_file = $xml->asXML($file);
            }
        }
    }

//    public function createDeploymentXML($site) {
//        $component = $xml->addChild('component');
//        $component->addAttribute('name', 'PublishConfigData');
//        $component->addAttribute('serverName', $site->name);
//
////        $xml_file = $xml->asXML( 'files/' . $site->name . '.xml');
//    }

    public function createDataSources($sites)
    {
        foreach ($sites as $name => $site) {
            $this->createDataSource($site, $name);
        }
    }

    public function createDataSource($site, $name) {
        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><project version="4"></project>');
        $component = $xml->addChild('component');
        $component->addAttribute('name', 'DataSourceManagerImpl');
        $component->addAttribute('format', 'xml');
        $component->addAttribute('multifile-model', 'true');

        $dataSource = $component->addChild('data-source');
        $dataSource->addAttribute('source', 'LOCAL');
        $dataSource->addAttribute('name', 'concrete5@localhost');
        $dataSource->addAttribute('uuid', 'f0b568aa-2d3a-480e-9313-8a59b1b01555');
        $dataSource->addChild('driver-ref', 'mysql');
        $dataSource->addChild('synchronize', 'true');
        $dataSource->addChild('jdbc-driver', 'com.mysql.jdbc.Driver');
        $dataSource->addChild('jdbc-url', 'jdbc:mysql://localhost:3306/concrete5');
        $dataSource->addChild('driver-ref', 'mysql');
        $dataSource->addChild('driver-ref', 'mysql');
        $dataSource->addChild('driver-ref', 'mysql');


//        $xml_file = $xml->asXML( 'files/' . $name . '.xml');
    }

    private function generateWebServerId() {
        return time();
    }

}