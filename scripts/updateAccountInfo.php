#!/usr/bin/php
<?php

require_once __DIR__ . '/../bootstrap.php';

use GuzzleHttp\Client;
use GW2Tracker\UpdateAccountInfo\{UpdateAccountInfo,UpdateAccountInfoGateway,UpdateAccountInfoController};

$dbPath = getenv('DB_PATH');
$Client = new Client();
$PDO = new PDO("sqlite:$dbPath");
$UpdateAccountInfoGateway = new UpdateAccountInfoGateway($Client,$PDO);
$UpdateAccountInfo = new UpdateAccountInfo($UpdateAccountInfoGateway);
$UpdateAccountInfoController = new UpdateAccountInfoController($UpdateAccountInfo);

$UpdateAccountInfoController();