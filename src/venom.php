#! /usr/bin/env php
<?php

use Venom\SetCommand;
use Venom\ShowCommand;
use Venom\RemoveCommand;
use Venom\SudoerCommand;
use Venom\UpdateCommand;
use Symfony\Component\Console\Application;

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
$app->add(new SudoerCommand());

$app->run();
