<?php

class SshConfig
{
    public function createConfigFile($sites)
    {
        $data = "Host *\n";
        $data .= "    UseKeychain yes\n";
        $data .= "    IdentitiesOnly yes\n";
        $data .= "    TCPKeepAlive yes\n";
        $data .= "    \n";

        foreach ($sites as $site) {
            $data .= "Host {$site->name}\n";
            $data .= "    Hostname {$site->hostname}\n";
            $data .= "    User {$site->username}\n";
            $data .= "    IdentityFile {$site->keyfile}\n";
            $data .= "\n";
        }
        file_put_contents('/Users/biplob/.ssh/config', $data);
    }
}