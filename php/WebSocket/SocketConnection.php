<?php
require_once(__DIR__ . '/WebSocketServer.php');
require_once(__DIR__ . '/../Processing/SobelEffect.php');

class SocketConnection extends WebSocketServer {
  private static $imageType = 'data:image/webp;base64,';

  function __construct($addr, $port) {
    parent::__construct($addr, $port);
  }

  protected function process ($user, $message) {
    // echo 'User sent: '. $message . PHP_EOL;

    foreach ($this->users as $currentUser) {
      if($currentUser === $user) {
        $message = explode(',', $message, 2);

        if(count($message) < 2) {
          $imageData = $message[0];
        }

        else {
          $imageData = $message[1];
        }

        $imageDecode = base64_decode($imageData);
        $image = imagecreatefromstring($imageDecode);

        if($image) {
          $sobelEffect = new SobelEffect($image, imagesx($image), imagesy($image));
          $result = $sobelEffect->applySobel();

          ob_start();
          imagejpeg($result);
          $imageString = ob_get_contents();
          ob_end_clean();

          imagedestroy($result);
          
          $response = self::$imageType . base64_encode($imageString);

          $this->send($currentUser, $response);
        }
      }
    }
  }

  protected function connected ($user) {
    echo 'User connected' . PHP_EOL;
  }

  protected function closed ($user) {
    echo 'User disconnected' . PHP_EOL;
  }
}
?>
