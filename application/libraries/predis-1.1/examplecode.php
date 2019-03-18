<?php
require 'autoload.php';
$client = new Predis\Client(array(
  //'host' => '127.0.0.1',
  //'port' => 6379,
  'password' => 'TheirWasAJungleWithTwoChimpangiz'
));
$client->set('foo', 'cowabunga');
$response = $client->get('foo');
echo $response;
?>