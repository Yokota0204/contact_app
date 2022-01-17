<?php
namespace App\Logging;

use Monolog\Processor\IntrospectionProcessor;
use Monolog\Logger;

class LogProcessor
{
  public function __invoke($logging)
  {
    /* プロセッサーを作成 */
    $introspectionProcessor = new IntrospectionProcessor(Logger::DEBUG, [], 4);
    /* ログの各ハンドラにプロセッサーを設定する */
    foreach ($logging->getHandlers() as $handler) {
      $handler->pushProcessor($introspectionProcessor);
    }
  }
}