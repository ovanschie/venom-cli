#!/usr/bin/env bash

wget https://raw.githubusercontent.com/ovanschie/venom-cli/venom.phar
chmod +x venom.phar
sudo mv venom.phar /usr/local/bin/venom
venom --version