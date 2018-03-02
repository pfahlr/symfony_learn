<?php
namespace App\Service;

use App\Service\SiteUpdateManager;
use Symfony\Bridge\Doctrine\Logger\DbalLogger;

class TestService {
  private $update_manager;

  public function __construct(DbalLogger $logger){
  //  $this->update_manager = $manager;
  $logger->startQuery("SHOW TABLES");
  }

  public function doSomething(){
    //$this->update_manager->notifyOfSiteUpdate();
  }

}
