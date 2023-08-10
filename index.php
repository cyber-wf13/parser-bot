<?php

use Testbot\Core;

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

function prettyResponse($content, $fileName = 'response.json', $isJson = true)
{
  if (is_null($content)) {
    return;
  }

  $fileContent = json_encode($content, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE,);

  if (!$isJson) {
    $fileContent = $content;
  }
  file_put_contents($fileName,  $fileContent);
}

require __DIR__ . '/vendor/autoload.php';
try {

  prettyResponse(json_decode(file_get_contents('php://input')));
  Core::getUpdate();
} catch (Error $err) {
  $errorLog = nl2br("<b>" . date('j-m-o H:i:s') . "</b>" . " Line: " . "{$err->getLine()} in file {$err->getFile()}: {$err->getMessage()} \n");
  file_put_contents('log.html', $errorLog, FILE_APPEND);
}
