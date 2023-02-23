<?php

/**
 * Method which generate random string
 * @param mixed $length
 * @return string
 */
function generateString($length = 6)
{
  $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHI JKLMNOPRQSTUVWXYZ0123456789";
  $string = "";
  $clen = strlen($chars) - 1;

  while (strlen($string) < $length) {
    $string .= $chars[mt_rand(0, $clen)];
  }

  return $string;
}

?>