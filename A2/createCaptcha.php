<?php
session_set_cookie_params(0, "", "");
session_start();
$font1 = "LEVIBRUSH.TTF";
$font2 = "LaBelleAurore.ttf";

$length = 7;
$cstring1 = substr(str_shuffle(md5(time())),0,$length);
$cstring2 = substr(str_shuffle(md5(time())),0,$length);

$ctext = $cstring1.$cstring2;
$_SESSION["captcha"] = $ctext;

//Image size
$width = 300;
$height = 200;

//Create image
$image = imagecreatetruecolor($width,$height);

//Colors
$black = imagecolorallocate($image, 0, 0, 0);
$grey = imagecolorallocate($image, 204,204, 204);
$red = imagecolorallocate($image, 200, 100, 90);
$color = imagecolorallocate($image, 155,50,255);

ImageFill($image, 0, 0, $black);
ImageRectangle($image,0, 0, $width-1, $height-1, $grey);
imagefilledrectangle($image, 20, 20, $width-20, $height-20, $grey);

imagettftext($image, 25, 30, 40, 115, $red, $font1, $cstring1);
imagettftext($image, 30, -20, 130, 115, $color, $font2, $cstring2);

header('Content-Type: image/png');
ImagePNG($image);
ImageDestroy($image);

?>