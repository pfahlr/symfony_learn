<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Routing\Annotation\Route;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use App\Service\MessageGenerator;
use App\Service\SiteUpdateManager;

use App\Service\TestService;

class ServiceTestController extends Controller {

  /**
  * @Route("/servicetest", name="servicetest_home")
  */
  public function homepage(TestService $testservice){
    $testservice->doSomething();
    return new Response('<h1>Welcome To Service Test!'.$testservice->doSomething().'</h2>');
  }


  /**
  * @Route ("/servicetest/message_generator", name="servicetest_message_generator")
  */

  public function message_generator(MessageGenerator $generator)
  {
    $result = $generator->getHappyMessage();

    $this->addFlash('success', $result);

    return $this->render('home/page.html.twig', ['val'=>$result]);
  }

  /**
  * @Route("/servicetest/site_update_manager", name="site_update_manager")
  */
  public function site_update_manager(SiteUpdateManager $manager) {
    if($message = $manager->notifyOfSiteUpdate()) {$this->addFlash('success',$message);}
    return $this->render('home/page.html.twig', ['val'=>'blank']);

  }

}
