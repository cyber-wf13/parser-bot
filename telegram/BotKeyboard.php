<?php

namespace Testbot;

use Testbot\Parser\Parser;

class BotKeyboard
{
  public static function video($data = '')
  {
    $activeVideoFlag = Parser::getFlagFromFile('video');
    if ($activeVideoFlag) {
      BotMethods::sendMessage("Надішліть будь ласка посилання на відео. Після скачування та опрацювання я відправлю готове відео, тому будь ласка, очікуйте");
    } else {
      BotCommands::initCommands('start');
    }
  }
}
