<?php namespace Fotheby\Controllers;

use Fotheby\Util\DataAccess;

class ExpertSelection extends Controller
{

  public function display()
  {
    $dataAccess = new DataAccess();
    $json = $dataAccess->get('expert');
    $list = json_decode($json);



    $data = [
      'experts' => $list,
      'action'  => 'expert-selected',
      'method'  => 'POST'
    ];

    $html = $this->view->render("ExpertSelection", $data);
    $this->response->setContent($html);
  }

  public function store()
  {
    $data = json_decode($this->request->getParameter("json"), true);

    foreach ($data as $key => $value) {
      if ( $value == true )
      {
        $id = (int)preg_replace('/^expert-/', '', $value);
      }
    }

    $dataAccess = new DataAccess();
    $json = $dataAccess->get("expert/{$id}");
    $list = json_decode($json, true);

    $expert = [
      'id' => $id,
      'title' => $list['title'],
      'firstName' => $list['firstName'],
      'surname' => $list['surname'],
      'email' => $list['emailAddress'],
    ];

    session_start();
    $_SESSION['expert'] = $expert;
  }

  public function retrieve()
  {
    session_start();
    $expert = $_SESSION['expert'];

    $data = [
      'expert' => $expert
    ];

    $html = $this->view->render("ExpertDetails", $data);
    $this->response->setContent($html);
  }

  // public function search($params)
  // {
  //   $dataAccess = new DataAccess();
  //   // $json = $dataAccess->get('expert/search');
  //   $json = $dataAccess->get('expert');
  //   $list = json_decode($json);

  //   $data = [
  //     'experts' => $list
  //   ];

  //   $html = $this->view->render("ExpertSelection", $data);
  //   $this->response->setContent($html);
  // }

}