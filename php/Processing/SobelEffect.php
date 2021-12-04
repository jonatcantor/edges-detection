<?php
class SobelEffect {
  private $width;
  private $height;
  private $image;
  private $result;

  function __construct($image, $width, $height) {
    $this->image = $image;
    $this->width = $width;
    $this->height = $height;
    $this->result = imagecreatetruecolor($this->width, $this->height);
  }

  function applySobel() {
    for($i = 1; $i < $this->width - 1; $i++) {
      for($j = 1; $j < $this->height - 1; $j++) {
        $sobelMatrix[0][0] = $this->getGrayColor($this->image, $i-1, $j-1);
        $sobelMatrix[0][1] = $this->getGrayColor($this->image, $i-1, $j);
        $sobelMatrix[0][2] = $this->getGrayColor($this->image, $i-1, $j+1);
        $sobelMatrix[1][0] = $this->getGrayColor($this->image, $i,   $j-1);
        $sobelMatrix[1][2] = $this->getGrayColor($this->image, $i,   $j+1);
        $sobelMatrix[2][0] = $this->getGrayColor($this->image, $i+1, $j-1);
        $sobelMatrix[2][1] = $this->getGrayColor($this->image, $i+1, $j);
        $sobelMatrix[2][2] = $this->getGrayColor($this->image, $i+1, $j+1);

        $edge = (int) $this->convolution($sobelMatrix);

        if($edge > 255) $edge = 255;
        if($edge < 0) $edge = 0;

        imagesetpixel($this->result, $i, $j, imagecolorallocate($this->result, $edge, $edge, $edge));
      }
    }

    return $this->result;
  }

  private function getGrayColor($image, $x, $y){
    $rgb = imagecolorat($image, $x, $y);
    $r = ($rgb >> 16) & 0xFF;
    $g = ($rgb >> 8) & 0xFF;
    $b = $rgb & 0xFF;
    
    return round($r * 0.3 + $g * 0.59 + $b * 0.11);
  }

  private function convolution($sobelMatrix){
    $gx = ($sobelMatrix[0][0] * +1) +
          ($sobelMatrix[0][1] * +2) +
          ($sobelMatrix[0][2] * +1) +
          ($sobelMatrix[2][0] * -1) +
          ($sobelMatrix[2][1] * -2) +
          ($sobelMatrix[2][2] * -1);

    $gy = ($sobelMatrix[0][0] * +1) +
          ($sobelMatrix[0][2] * -1) +
          ($sobelMatrix[1][0] * +2) +
          ($sobelMatrix[1][2] * -2) +
          ($sobelMatrix[2][0] * +1) +
          ($sobelMatrix[2][2] * -1);

    return sqrt(pow($gx, 2) + pow($gy, 2));
  }
}
?>
