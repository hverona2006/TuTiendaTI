<?php

/**
 * Opens new image
 *
 * @param $filename
 */
function icreate($filename)
{
  $mime = mime_content_type($filename);
  if ($mime=='image/jpeg')
    return imagecreatefromjpeg($filename);
  /* Add as many formats as you can */
}

/**
 * Resize maintaining aspect ratio
 *
 * @param $image
 * @param $height
 */
function resizeAspect($image, $height)
{
  $aspect = imagesx($image) / imagesy($image);
  $width = $height * $aspect;
  $new = imageCreateTrueColor($width, $height);

  imagecopyresampled($new, $image, 0, 0, 0, 0, $width, $height, imagesx($image), imagesy($image));
  return $new;
}
$rtmd="../../photo/thumbs-md/";
$rtsm="../../photo/thumbs-sm/";

?>
