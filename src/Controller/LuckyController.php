<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;


class LuckyController extends Controller
{
  /**
  * @Route ("lucky/number", name="lucky")
  */
  public function number(LoggerInterface $logger)
  {
    $number = mt_rand(0,100);
    $logger->info("lucky number:".$number);

    return $this->redirectToRoute('lucky_number', array('number'=>$number));
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

  /**
   * @Route("lucky/exception", name="lucky_exception")
   */
  public function lucky_exception(){
      //404
      throw $this->createNotFoundException('test exception');
      //500
      throw new \Exception('test exception');
  }

  /**
   * @Route("lucky/request", name="lucky_request")
   *
   */
  public function lucky_request(Request $request) {
      $page = $request->query->get('page',1);
      return new Response('page:'.$page);
  }

  /**
   * @Route("lucky/session/set", name="lucky_session_set")
   */
  public function lucky_session_set(SessionInterface $session) {
      $session->set('foo','bar');
      return new Response('set foo=bar');
  }

  /**
    * @Route("lucky/session/get", name="lucky_session_get")
    */
  public function lucky_session_get(SessionInterface $session) {
      $data = $session->get('foo');
      return new Response('read foo='.$data);
  }

    /**
     * @Route("lucky/flash", name="lucky_flash")
     */
  public function lucky_flash(){
      $this->addFlash('notice','Test notice');
      $this->addFlash('error','Test error');
      $this->addFlash('warning','Test warning');
      $this->addFlash('success','Test success');

      return $this->render('lucky/test.html.twig', ['content'=>['some content'],'title'=>'Flash Messages']);
  }

  /**
   * @Route("lucky/request_response", name="lucky_request_response")
   */
  public function lucky_request_response(Request $request){
     $content[] = 'is AJAX?:'.$request->isXmlHttpRequest();
     $content[] = 'preferred language:'.$request->getPreferredLanguage(array('en', 'fr'));
     $content[] = '$_GET[page]'.$request->query->get('page');
     $content[] = '$_POST[page]'.$request->request->get('page');
     $content[] = '$_SERVER[http_host]'.$request->server->get('http_host');
     $content[] = '$_FILES[]'.$request->files->get('foo');
     $content[] = 'cookie - PHPSESSID'.$request->cookies->get('PHPSESSID');
     $content[] = 'header-host'.$request->headers->get('host');
     $content[] = 'header-content type'.$request->headers->get('content_type');
     $menu = $this->get_nav();

     return $this->render('lucky/test.html.twig', ['content'=>$content,'title'=>'Request Data','menu'=>$menu]);

  }

  /**
   * @Route("lucky/response_type",name="lucky_response_type")
   */
  public function lucky_response_type(){
      $content = "
      Normal
      line break
      delimited 
      text 
      file 
      ";
      $response = new Response($content);
      $response->headers->set('Content-Type','text/css');

      return $response;
  }
  /**
   * @Route("lucky/json", name="lucky_json")
   */
  public function lucky_json() {
      $menu = $this->get_nav();

      return $this->json(['array'=>'value','another'=>'value', 'yet'=>['another','array','of','values']]);
  }

  /**
   * @Route("lucky/download", name="lucky_download")
   *
   */
  public function lucky_download() {
      return $this->file('/home/rick/Downloads/The Golden Book Of Chemistry Experiments.pdf');
  }

  private function get_nav() {
      $router = $this->container->get('router');
      /** @var $collection \Symfony\Component\Routing\RouteCollection */
      $collection = $router->getRouteCollection();
      $allRoutes = $collection->all();

      $menu = array_map(function($obj,$key){

          if($key && strstr($obj->getDefault('_controller'),'LuckyController')) {
              //var_dump( 'key:'.$key.' - '.$obj->getPath());
              return (['key'=>$key, 'path'=>$obj->getPath()]);
          }

      }, $allRoutes, array_keys($allRoutes));

      $menu = array_filter($menu, function($value){return !empty($value);});

      return $menu;
  }
}
