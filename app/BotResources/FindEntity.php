<?php
namespace App\BotResources;

class FindEntity
{
  public static function findEntityKeys($array)
  {
      $keys = array();

      foreach ($array as $key => $value) {
          $keys[] = $key;

          if (is_array($value)) {
              $keys = array_merge($keys, $this->findEntityKeys($value));
          }
      }
      return $keys;
  }
}
