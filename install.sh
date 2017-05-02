#!/usr/bin/env bash

curl https://raw.githubusercontent.com/ovanschie/venom-cli/master/venom.phar
chmod +x venom.phar
sudo mv venom.phar /usr/local/bin/venom
venom --version
