#! /usr/bin/env php
<?php

use Symfony\Component\Console\Application;
use Venom\UpdateCommand;
use Venom\SetCommand;
use Venom\RemoveCommand;
use Venom\ShowCommand;

require '../vendor/autoload.php';

$app = new Application('Venom CLI', '@package_version@');

$app->add(new UpdateCommand());
$app->add(new SetCommand());
$app->add(new RemoveCommand());
$app->add(new ShowCommand());

$app->run();