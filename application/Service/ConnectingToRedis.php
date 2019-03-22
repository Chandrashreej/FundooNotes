<?php
include '/var/www/html/codeigniter/application/libraries/predis-1.1/autoload.php';
class ConnectingToRedis
{

    public static function redisConnection()
    {

        $client = new Predis\Client(array(
            'host' => '127.0.0.1',
            'port' => 6379,
            'password' => 'TheirWasAJungleWithTwoChimpangiz',
        ));
        return $client;
    }
}
