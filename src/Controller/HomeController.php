<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Routing\Annotation\Route;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use App\Service\MessageGenerator;

class HomeController extends Controller {
  /**
  * @Route ("/", name="home")
  */
  public function homepage(MessageGenerator $generator)
  {

    $result = $generator->getHappyMessage();

    $this->addFlash('success', $result);

    return $this->render('home/page.html.twig', ['val'=>$result]);


  }




}
