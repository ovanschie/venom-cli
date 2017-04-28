#! /usr/bin/env php

<?php

use Symfony\Component\Console\Application;
use Venom\SetCommand;
use Venom\RemoveCommand;
use Venom\ShowCommand;

require 'vendor/autoload.php';

$app = new Application('Venom CLI', '0.0.1');

$app->add(new SetCommand());
$app->add(new RemoveCommand());
$app->add(new ShowCommand());

$app->run();