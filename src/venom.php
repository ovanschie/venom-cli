#! /usr/bin/env php
<?php

use Symfony\Component\Console\Application;
use Venom\UpdateCommand;
use Venom\SetCommand;
use Venom\RemoveCommand;
use Venom\ShowCommand;

require '../vendor/autoload.php';

$app = new Application('
 __   _____ _ __   ___  _ __ ___  
 \ \ / / _ \ \'_ \ / _ \| \'_ ` _ \ 
  \ V /  __/ | | | (_) | | | | | |
   \_/ \___|_| |_|\___/|_| |_| |_| ', '@package_version@');

$app->add(new UpdateCommand());
$app->add(new SetCommand());
$app->add(new RemoveCommand());
$app->add(new ShowCommand());

$app->run();