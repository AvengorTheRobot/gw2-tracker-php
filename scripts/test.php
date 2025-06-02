!#/usr/local/bin/php
<?php

require_once __DIR__ . '/../bootstrap.php';

use GuzzleHttp\Client;
use GW2Tracker\UpdateAccountInfo\UpdateAccountInfoGateway;

$dbPath = getenv('DB_PATH');
$Client = new Client();
$PDO = new PDO("sqlite:$dbPath");
$UpdateAccountInfoGateway = new UpdateAccountInfoGateway($Client,$PDO);
$name = $UpdateAccountInfoGateway->getName();




$response = $Client->get('https://api.guildwars2.com/v2/build');
$data = json_decode($response->getBody(), true);

echo "Build ID: " . var_dump($data) . PHP_EOL;
