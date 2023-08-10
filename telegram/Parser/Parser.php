<?php

namespace Testbot\Parser;

use Testbot\Core;

class Parser
{
  public static function getFlagFromFile($flag = 'video')
  {
    $storedMessages = json_decode(file_get_contents('messages.json'), true);
    return $storedMessages[Core::$QUERY_PARAMS['chat_id']][$flag];
  }

  public static function saveToFile($flag = 'video', $value = true)
  {
    $storedMessages = json_decode(file_get_contents('messages.json'), true);
    $messages = [Core::$QUERY_PARAMS['chat_id'] => [$flag => $value]];

    $storedMessages[Core::$QUERY_PARAMS['chat_id']] = $messages[Core::$QUERY_PARAMS['chat_id']];
    file_put_contents('messages.json', json_encode($storedMessages));
  }
}
