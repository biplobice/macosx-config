<?php

class SshConfig
{
    public function createConfigFile($sites)
    {
        $data = "Host *
        UseKeychain yes
        IdentitiesOnly yes
        TCPKeepAlive yes
        \n";

        foreach ($sites as $site) {
            $data .= "Host {$site->name}\n";
            $data .= "    Hostname {$site->hostname}\n";
            $data .= "    User {$site->username}\n";
            $data .= "    IdentityFile {$site->keyfile}\n";
            $data .= "\n";
        }
        file_put_contents('/Users/YOUR_USER_ID/.ssh/config', $data);
    }
}