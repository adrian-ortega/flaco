<?php
use AOD\Http\Controllers\HomeController;

$app->get('/', HomeController::class . ':getIndex')->setName('home');