<?php

namespace Testbot\Curl;

use Error;

class Connect
{
  public static $CurlParams = [
    CURLOPT_HTTPHEADER => array("Content-Type: application/json; charset=utf-8"),
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HEADER => false,
  ];
  private static $handle;

  public static function init($url = '')
  {
    if (!$url || $url == '') {
      throw new Error("Put URL for request");
    }
    self::$handle = curl_init($url);
  }

  public static function exec()
  {
    // self::log();
    curl_setopt_array(self::$handle, self::$CurlParams);
    curl_exec(self::$handle);
    curl_close(self::$handle);
  }

  public static function setPostQuery($queryParams = [])
  {
    if (is_array($queryParams) && !empty($queryParams)) {
      self::$CurlParams[CURLOPT_POSTFIELDS] = json_encode($queryParams);
    }
    self::$CurlParams[CURLOPT_POST] = true;
  }

  public static function saveToFile($fileName)
  {
    if (strlen($fileName) === 0) {
      throw new Error('File name is required');
    }

    $file = fopen($fileName, "w");
    self::$CurlParams[CURLOPT_FILE] = $file;
  }

  private static function log()
  {
    self::saveToFile('log.json');
  }
}
