<?php

class VerifyAPICalls{

    public function verifyCalls(){
            $client = new Predis\Client(array(
            'host' => '127.0.0.1',
            'port' => 6379,
            'password' => 'TheirWasAJungleWithTwoChimpangiz'
          ));
          $response = $client->get('token');
          
    }
}

?>