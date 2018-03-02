<?php
namespace App\Service;

use App\Service\MessageGenerator;

class SiteUpdateManager {
  private $messageGenerator;
  private $mailer;
  private $adminEmail;

  public function __construct(MessageGenerator $generator, \Swift_Mailer $mailer, $adminEmail) {
    $this->messageGenerator = $generator;
    $this->mailer = $mailer;
    $this->adminEmail = $adminEmail;
    echo $adminEmail;
  }

  public function notifyOfSiteUpdate(){
    $happyMessage = $this->messageGenerator->getHappyMessage();
    $message = (new \Swift_Message('Site Just Updated'))
    ->setFrom('pfahlr@gmail.com')
    ->setTo($this->adminEmail)
    ->addPart('sent this message:'.$happyMessage.' to:'.$this->adminEmail);
    if( $this->mailer->send($message))
      return ('sent this message:'.$happyMessage.' to:'.$this->adminEmail);
    return "failed";
  }
}
