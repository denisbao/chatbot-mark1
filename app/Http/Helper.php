<?php
namespace App\Http;

class Helper
{
  public static function array_keys_multi(array $array)
  {
      $keys = array();

      foreach ($array as $key => $value) {
          $keys[] = $key;

          if (is_array($value)) {
              $keys = array_merge($keys, array_keys_multi($value));
          }
      }

      return $keys;
  }
}
