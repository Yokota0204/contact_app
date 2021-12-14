<?php
namespace App\Logging;

use Monolog\Formatter\LineFormatter;

class LogFormatter
{
  public function __invoke($logging)
  {
    /* フォーマットを指定 */
    $format = "%datetime% [%channel%.%level_name%] %extra.class%@%extra.function%(%extra.line%) - %message%" . PHP_EOL;
    /* 日付のフォーマットを指定 */
    $dateFormat = "Y/m/d H:i:s";
    /* フォーマットを作成 */
    $lineFormatter = new LineFormatter($format, $dateFormat, 1, 1);
    /* 各ハンドラにフォーマットを代入 */
    foreach ($logging->getHandlers() as $handler) {
      $handler->setFormatter($lineFormatter);
    }
  }
}