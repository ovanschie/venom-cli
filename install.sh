#!/usr/bin/env bash

curl https://raw.githubusercontent.com/ovanschie/venom-cli/master/venom-cli.phar -O
chmod +x venom-cli.phar
sudo mv venom-cli.phar /usr/local/bin/venom
venom --version