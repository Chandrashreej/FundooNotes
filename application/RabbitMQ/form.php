<?php

include '/var/www/html/codeigniter/application/RabbitMQ/receiver.php';
class Form
{
    public function callingReceiver()
    {
        /**
         * calling the receiver
         */
        $obj = new Receiver();

        $obj->receiverMail();

    }

}
