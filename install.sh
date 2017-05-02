#!/usr/bin/env bash

curl https://github.com/ovanschie/venom-cli/raw/master/venom.phar
chmod +x venom.phar
sudo mv venom.phar /usr/local/bin/venom
venom --version
