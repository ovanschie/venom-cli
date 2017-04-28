#!/usr/bin/env bash

wget https://github.com/ovanschie/venom-cli/raw/master/venom.phar
chmod +x venom.phar
sudo mv venom.phar /usr/local/bin/venom
venom --version