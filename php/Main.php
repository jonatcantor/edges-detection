<?php
if(isset($_SERVER['HTTP_ACCEPT'])) {
  echo 'Http requests are not allowed';
  return;
}

require_once(__DIR__ . '/vendor/autoload.php');
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

require_once(__DIR__ . '/WebSocket/SocketConnection.php');

$socket = new SocketConnection($_ENV['APP_IP_ADRESS'], $_ENV['APP_PORT']);

try {
  $socket->run();
} catch(Exception $e) {
  $socket->stdout($e->getMessage());
}
?>
