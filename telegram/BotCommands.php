<?php

namespace Testbot;

use Error;
use Testbot\Parser\Parser;

class BotCommands
{

  protected static function start()
  {
    $text = 'Доброго дня. Даний бот призначений для скачування відео з відповідних ресурсів. Введіть команду /help для перегляду всіх можливих команд';
    BotMethods::sendMessage($text);
  }

  protected static function help()
  {
    $text = "Коротка довідка: \n /start - початок роботи \n /help - виводить всі команди. \n /key - виводить інтерактивну клавіатуру \n /video - скачати відео";
    BotMethods::sendMessage($text);
  }

  protected static function key()
  {
    $keyboard = [[['text' => 'Привіт', 'callback_data' => 'hello']], [['text' => 'Бувай', 'callback_data' => 'goodbye']]];
    BotMethods::sendMessageKeyboard('Тестова клавіатура', $keyboard);
  }

  protected static function video()
  {
    $text = "Будь ласка виберіть платформу звідки потрібно скачувати";
    $keyboard = [[['text' => 'Youtube', 'callback_data' => 'video']]];
    BotMethods::sendMessageKeyboard($text, $keyboard);
    Parser::saveToFile('video', true);
  }

  public static function initCommands($command)
  {
    if (method_exists(self::class, $command)) {
      self::$command();
    } else {
      throw new Error('This command is not init');
    }
  }
}
