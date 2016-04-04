<?php namespace Fotheby\Controllers;

use Fotheby\Util\DataAccess;
use Fotheby\Util\Session;

class ClassificationSelection extends Controller
{
  public function display()
  {
    $data = [];

    $dataAccess = new DataAccess();
    $json = $dataAccess->get('classification');
    $list = json_decode($json);

    session_start();
    if ( array_key_exists('classifications', $_SESSION) )
    {
      $data['selected'] = $_SESSION['classifications'];
    }

    $data['classifications'] = $list;
    $data['action'] = 'classification-selected';
    $data['method']  = 'POST';

    $html = $this->view->render("ClassificationSelection", $data);
    $this->response->setContent($html);
  }

  public function store()
  {
    $assoc = true;
    $data = json_decode($this->request->getParameter("json"), $assoc);
    $list = [];

    var_dump($data);

    foreach ($data as $key => $value)
    {
        $id = (int)preg_replace('/^classification-/', '', $value['classification']);
        $dataAccess = new DataAccess();
        $json = $dataAccess->get("classification/{$id}");
        $list[] = json_decode($json, true);
    }
    session_start();
    $_SESSION['classifications'] = $list;
  }

  public function retrieve()
  {
    session_start();
    $classifications = $_SESSION['classifications'];

    $data = [
      'classifications' => $classifications
    ];

    $html = $this->view->render("ClassificationDetails", $data);
    $this->response->setContent($html);
  }
}


