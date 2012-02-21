<?php

include 'PZQClient.php';

$c = new PZQConsumer ("tcp://127.0.0.1:11132");

$ids = array ();
for ($i = 0; $i < 10000; $i++)
{
    $message = $c->consume ();
    $c->ack ($message);
    echo "Consumed {$i}" . PHP_EOL;
}

sleep (5);