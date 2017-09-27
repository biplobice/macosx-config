<?php
$file = 'sites.xml';
$xml = simplexml_load_file($file);

if (!$sites = $xml->site) {
    return 'Invalid XML file';
}

// Create ssh config file
// ~/.ssh/config
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
file_put_contents('config', $data);


// Create sequel pro favorites list file
// ~/Library/Application Support/Sequel Pro/Data/Favorites.plist
$data = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<!DOCTYPE plist PUBLIC \"-//Apple//DTD PLIST 1.0//EN\" \"http://www.apple.com/DTDs/PropertyList-1.0.dtd\">
<plist version=\"1.0\">
<dict>
	<key>Favorites Root</key>
	<dict>
		<key>Children</key>
		<array>

			<dict>
				<key>colorIndex</key>
				<integer>-1</integer>
				<key>database</key>
				<string></string>
				<key>host</key>
				<string></string>
				<key>id</key>
				<integer>3725127661940185233</integer>
				<key>name</key>
				<string>localhost</string>
				<key>port</key>
				<string></string>
				<key>socket</key>
				<string></string>
				<key>sshHost</key>
				<string></string>
				<key>sshKeyLocation</key>
				<string></string>
				<key>sshKeyLocationEnabled</key>
				<integer>0</integer>
				<key>sshPort</key>
				<string></string>
				<key>sshUser</key>
				<string></string>
				<key>sslCACertFileLocation</key>
				<string></string>
				<key>sslCACertFileLocationEnabled</key>
				<integer>0</integer>
				<key>sslCertificateFileLocation</key>
				<string></string>
				<key>sslCertificateFileLocationEnabled</key>
				<integer>0</integer>
				<key>sslKeyFileLocation</key>
				<string></string>
				<key>sslKeyFileLocationEnabled</key>
				<integer>0</integer>
				<key>type</key>
				<integer>1</integer>
				<key>useSSL</key>
				<integer>0</integer>
				<key>user</key>
				<string>root</string>
			</dict>			
		\n";

foreach ($sites as $site) {
    $siteName = $site->name;
    if($site->database->prefix) {
        $siteName = $site->database->prefix . $site->name;
    }

    $data .= "
            <dict>
				<key>colorIndex</key>
				<integer>-1</integer>
				<key>database</key>
				<string></string>
				<key>host</key>
				<string>{$site->database->hostname}</string>
				<key>id</key>
				<integer>-2490508938092353399</integer>
				<key>name</key>
				<string>{$siteName}</string>
				<key>port</key>
				<string>{$site->database->port}</string>
				<key>socket</key>
				<string></string>
				<key>sshHost</key>
				<string>{$site->hostname}</string>
				<key>sshKeyLocation</key>
				<string>{$site->keyfile}</string>
				<key>sshKeyLocationEnabled</key>
				<integer>1</integer>
				<key>sshPort</key>
				<string>{$site->port}</string>
				<key>sshUser</key>
				<string>{$site->username}</string>
				<key>sslCACertFileLocation</key>
				<string></string>
				<key>sslCACertFileLocationEnabled</key>
				<integer>0</integer>
				<key>sslCertificateFileLocation</key>
				<string></string>
				<key>sslCertificateFileLocationEnabled</key>
				<integer>0</integer>
				<key>sslKeyFileLocation</key>
				<string></string>
				<key>sslKeyFileLocationEnabled</key>
				<integer>0</integer>
				<key>type</key>
				<integer>2</integer>
				<key>useSSL</key>
				<integer>0</integer>
				<key>user</key>
				<string>{$site->database->username}</string>
			</dict>\n";
}
$data .= "
		</array>
		<key>IsExpanded</key>
		<true/>
		<key>Name</key>
		<string>FAVORITES</string>
	</dict>
</dict>
</plist>";

file_put_contents('Favorites.plist', $data);
