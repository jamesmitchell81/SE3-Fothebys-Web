<?php namespace Fotheby\Controllers;

use Fotheby\Util\DataAccess;

class ClientNewSelection extends Controller
{
  public function display()
  {

    $data = [];

    $html = $this->view->render("ClientNewEntry", $data);
    $this->response->setContent($html);
  }

  public function store()
  {
    $assoc = true;
    $data = json_decode($this->request->getParameter("json"), $assoc);

    // send to server and validate

    session_start();
    $_SESSION['client'] = $data;
  }


  public function retrieve()
  {
    session_start();
    $client = $_SESSION['client'];

    // get from server.

    $data = [
      'client' => $client
    ];

    $html = $this->view->render("ClientNewEntered", $data);
    $this->response->setContent($html);
  }
}