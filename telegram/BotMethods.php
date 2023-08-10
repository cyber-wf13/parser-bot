<?php

namespace Testbot;

use CURLFile;

class BotMethods
{
  public static function sendMessage($text = 'hello world!')
  {
    Core::$QUERY_URL = Core::$QUERY_URL . '/sendMessage';
    Core::setQueryParams(['text' => $text]);
  }

  public static function sendMessageKeyboard($text, $keyboard)
  {
    Core::setQueryParams([
      'reply_markup' => ['inline_keyboard' => $keyboard]
    ]);
    self::sendMessage($text);
  }

  public static function sendVideo($videoPath)
  {
    Core::$QUERY_URL = Core::$QUERY_URL . '/sendVideo';
    // $video = new CURLFile($videoPath);
    Core::setQueryParams(['video' => $videoPath]);
  }

  public static function getChat()
  {
    Core::$QUERY_URL = Core::$QUERY_URL . '/getChat';
  }
}
