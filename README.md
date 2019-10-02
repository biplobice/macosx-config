# macosx-config

- Add your sites informations on `sites.yaml` file as follows.

```
example1.com:
  name: example1.com
  host: 127.0.0.1
  user: ex-user
  sshKey: ~/.ssh/ex-user.pem
  env: prod
  database:
    host: 127.0.0.1
    user: root
    password: root
    port: 3306

example2.com:
  name: example2.com
  host: 127.0.0.1
  user: ex-user
  sshKey: ~/.ssh/ex-user.pem
  env: prod
  database: { host: 127.0.0.1, user: root, password: root, port: 3306 }
  
 ```
 
 - Run `php index.php` from your CLI or access the `index.php` from your browser. It'll generates the config files for you.
 
 [Note: I use this script to generate the config files for my Mac. You might need to change the output path to the classes.]
