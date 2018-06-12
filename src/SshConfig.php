<?php
namespace Biplob;

class SshConfig
{
    public function createConfigFile($sites)
    {
        $data = "Host *\n";
        $data .= "    UseKeychain yes\n";
        $data .= "    IdentitiesOnly yes\n";
        $data .= "    TCPKeepAlive yes\n";
        $data .= "    \n";

        foreach ($sites as $name => $site) {
            $data .= "Host {$name}\n";
            $data .= "    Hostname {$site['host']}\n";
            $data .= "    User {$site['user']}\n";
            if (isset($site['sshKey'])) {
                $data .= "    IdentityFile {$site['sshKey']}\n";
            }

            if (isset($site['port'])) {
                $data .= "    Port {$site['port']}\n";
            }

            $data .= "\n";
        }
        file_put_contents($_SERVER['HOME'] . '/.ssh/config', $data);
    }
}