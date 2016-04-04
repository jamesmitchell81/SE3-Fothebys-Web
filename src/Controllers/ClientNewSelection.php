<?php namespace Fotheby\Controllers;

use Fotheby\Util\DataAccess;

class ClientNewSelection extends Controller
{
  public function display()
  {

    $data = [];

    session_start();
    if ( array_key_exists('client', $_SESSION) )
    {
      $data['client'] = $_SESSION['client'];
    }

    $html = $this->view->render("ClientNewEntry", $data);
    $this->response->setContent($html);
  }

  public function store()
  {
    $assoc = true;
    $data = json_decode($this->request->getParameter("json"), $assoc);

    $out = [
      'title' => $data['title'],
      'firstName' => $data['firstName'],
      'surname' => $data['surname'],
      'emailAddress' => $data['emailAddress'],
      'telNumber' => $data['telNumber'],
      'contactAddress' => [
        'firstLine' => $data['firstLine'],
        'secondLine' => $data['secondLine'],
        'townCity' => $data['townCity'],
        'postalCode' => $data['postalCode']
      ]
    ];

    $send = json_encode($out);
    $access = new DataAccess();
    $access->setContentType("application/json");
    $response = $access->post('clients', $send);

    var_dump($response);

    $id = 0;
    if ( preg_match('/(201 Created)/', $response) )
    {
      $response = preg_split("/\n/", $response);
      foreach ($response as $value) {
        if ( preg_match("/(Location:)/", $value))
        {
          $parts = preg_split("/\//", $value);
          $last = count($parts) - 1;
          $id = str_replace("\r", "", $parts[$last]);
        }
      }
    }

    $client = [
      'id' => $id,
      'details' => $data
    ];

    session_start();
    $_SESSION['client'] = $client;
  }


  public function retrieve()
  {
    session_start();
    $client = $_SESSION['client'];

    $data = [
      'client' => $client
    ];

    $html = $this->view->render("ClientNewEntered", $data);
    $this->response->setContent($html);
  }
}