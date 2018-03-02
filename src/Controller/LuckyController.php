<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Routing\Annotation\Route;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Psr\Log\LoggerInterface;

class LuckyController extends Controller
{
  /**
  * @Route ("lucky/number", name="lucky")
  */
  public function number(LoggerInterface $logger)
  {
    $number = mt_rand(0,100);
    $logger->info("lucky number:".$number);
    return $this->render('lucky/number.html.twig', array(
      'number'=>$number,
      'list'=>[1,2,3,4,5],
    ));
    /*
    return new Response(
      '<html><body>Lucky Number:'.$number.'</body></html>'
    );
    */
  }

  /**
  * @Route ("lucky/num/{number}", name="lucky_number", requirements={"number"="\d+"}, defaults={"number"="1"})
  */
  public function lucky_number($number=12) {
    return $this->render('lucky/number.html.twig', array(
      'number'=>$number,
      'list'=>[5,4,3,2,1],
    ));
  }
}
