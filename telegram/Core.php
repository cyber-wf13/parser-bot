<?php

namespace Testbot;

use Error;
use Testbot\Curl\Connect;
use Testbot\Parser\Parser;

class Core
{

  protected static $BOT_TOKEN = "1084695069:AAGaSzGyg7lxdfLIpvFOJr-2UpUYXvEaTIY";
  protected static $BOT_NAME = "My_wfBot";
  protected static $API_URL = "https://api.telegram.org/bot";
  public static $BOT_URL = "https://8a2d-195-177-124-178.ngrok-free.app";
  public static $QUERY_URL;
  public static $QUERY_PARAMS = ['chat_id' => 0];
  public static $BLOCK_INPUT = true;

  private static function proccessCommand($message)
  {
    BotCommands::initCommands($message);
    self::execQuery();
  }

  // Можливо, є смисл перенсти логіку в BotMessage 
  private static function proccesMessage($update)
  {
    $text = $update['message']['text'];
    $activeVideoFlag = Parser::getFlagFromFile('video');
    if ($activeVideoFlag) {
      BotMessage::url($text);
    } else {
      BotCommands::initCommands('start');
    }
    self::execQuery();
  }

  private static function proccesCallbackQuery($cbQuery)
  {
    if (array_key_exists('reply_markup', $cbQuery['message'])) {
      $methodName = $cbQuery['data'];
      if (method_exists(BotKeyboard::class, $methodName)) {
        BotKeyboard::{$methodName}($cbQuery['data']);
        self::execQuery();
      } else {
        throw new Error('Method in callback_data is not right');
      }
    }
  }

  public static function getUpdate()
  {
    $response = file_get_contents('php://input');
    $update = json_decode($response, true);

    // ДЛЯ РОБОТИ З JSON
    // file_put_contents('log.json', $response);

    if (!$update) {
      file_put_contents('log.txt', "Відбулася помилка при отриманні оновлення!");
      return;
    }

    if (array_key_exists('message', $update)) {
      self::setBaseParams($update['message']['chat']['id']);

      if (array_key_exists('entities', $update['message'])) {
        if ($update['message']['entities'][0]['type'] === 'bot_command') {
          $command = ltrim($update['message']['text'], '/');
          self::proccessCommand($command);
          return;
        }
      }

      self::proccesMessage($update);
    } else if (array_key_exists('callback_query', $update)) {
      self::setBaseParams($update['callback_query']['message']['chat']['id']);
      self::proccesCallbackQuery($update['callback_query']);
    }
  }

  public static function setQueryParams($params)
  {
    self::$QUERY_PARAMS = array_merge(self::$QUERY_PARAMS, $params);
  }

  private static function setBaseParams($chatId)
  {
    self::$QUERY_URL = self::$API_URL . self::$BOT_TOKEN;
    self::$QUERY_PARAMS['chat_id'] = $chatId;
  }

  private static function execQuery()
  {
    Connect::init(self::$QUERY_URL);
    Connect::setPostQuery(self::$QUERY_PARAMS);
    Connect::exec();
  }

  // Написати метод для швидкого створення клавіатури
  public static function setInlineKeyboard($buttons)
  {
    $keyboard = [];

    foreach ($buttons as $button) {
    }
  }
}
