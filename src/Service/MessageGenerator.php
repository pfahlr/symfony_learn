<?php
namespace App\Service;

use Psr\Log\LoggerInterface;

class MessageGenerator {
  private $logger;

  public function __construct(LoggerInterface $logger)
  {
    $this->logger = $logger;
  }

  public function getHappyMessage()
  {
    $messages = [
      'Test message',
      'another message!',
      'a third message',
      ];
    $this->logger->info("Generating A Message in ".__CLASS__);
    $index = array_rand($messages);
    $this->logger->info("found:".$messages[$index]);
    return $messages[$index];
  }
}
