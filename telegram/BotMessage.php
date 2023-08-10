<?php

namespace Testbot;

use Testbot\Parser\Parser;
use Testbot\Video\Youtube;

class BotMessage
{
  public static function url($url)
  {
    if (preg_match("/^http[s]?:\/\/[www\.]?/", $url)) {
      if (preg_match("/[a-z]*(youtu[\.]?be[\.com]?)*/", $url)) {
        // \/watch
        // prettyResponse($url, 'response.html', false);
        $yt = new Youtube($url);
        $yt->checkStorageSize();
        $yt->init();
        // $yt->getUrlVideoId($url);
        BotMethods::sendVideo(Core::$BOT_URL . '/' . $yt->baseFileName);
        Parser::saveToFile('video', false);
        // $yt->deleteVideo();
      }
      return;
    }
    BotMethods::sendMessage('url is bad ' . $url);
  }
}
